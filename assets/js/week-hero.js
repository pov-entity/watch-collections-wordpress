/**
 * DialByDay weekly hero: sync live labels to the seven watches already present
 * in the founder's 10-second footage. Playback drives state; no slideshow.
 */
(function () {
  'use strict';
  var hero = document.querySelector('[data-week-hero]');
  if (!hero) return;
  var video = hero.querySelector('[data-hero-video]');
  var tabs = Array.prototype.slice.call(hero.querySelectorAll('[data-hero-tab]'));
  var motion = hero.querySelector('[data-hero-motion]');
  var motionLabel = hero.querySelector('[data-hero-motion-label]');
  var count = hero.querySelector('[data-hero-count]');
  var day = hero.querySelector('[data-hero-day]');
  var moment = hero.querySelector('[data-hero-moment]');
  var style = hero.querySelector('[data-hero-style]');
  var announcer = hero.querySelector('[data-hero-announcer]');
  if (!video || tabs.length !== 7 || !motion || !day || !style || !moment || !count) return;

  // Scene boundaries measured against gemini_generated_video_9604232b.mp4.
  // Slightly offset from the dissolves so labels switch with the new watch.
  var starts = [0, 1.83, 3.13, 4.34, 5.82, 7.23, 8.76];
  var fullDuration = 10.0;
  var active = -1;
  var manualPause = false;
  var inViewport = true;
  var wasPlaying = false;
  var reducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var touchX = null, touchY = null;

  function getIndex(t) {
    for (var i = starts.length - 1; i >= 0; i--) {
      if (t >= starts[i]) return i;
    }
    return 0;
  }

  function paint(index, announce) {
    if (active !== index) {
      active = index;
      var tab = tabs[index];
      count.textContent = String(index + 1).padStart(2, '0');
      day.textContent = tab.getAttribute('data-day') || '';
      moment.textContent = tab.getAttribute('data-moment') || '';
      style.textContent = tab.getAttribute('data-style') || '';
      tabs.forEach(function (item, n) {
        item.classList.toggle('is-current', n === index);
        item.setAttribute('aria-pressed', n === index ? 'true' : 'false');
      });
    }
    if (announce && announcer) {
      announcer.textContent = day.textContent + ': ' + style.textContent + '. ' + moment.textContent;
    }
  }

  function updateProgress() {
    var t = Math.min(Math.max(video.currentTime || 0, 0), fullDuration - 0.001);
    var idx = getIndex(t);
    paint(idx, false);
    var end = idx === starts.length - 1 ? fullDuration : starts[idx + 1];
    var progress = Math.max(0, Math.min(1, (t - starts[idx]) / (end - starts[idx])));
    tabs.forEach(function (tab, n) {
      tab.style.setProperty('--hero-fill', n === idx ? progress : (n < idx ? 1 : 0));
    });
  }

  function refreshControl() {
    var paused = video.paused || manualPause;
    hero.classList.toggle('is-playing', !paused);
    motion.setAttribute('aria-pressed', paused ? 'true' : 'false');
    motion.setAttribute('aria-label', paused ? 'Play the weekly video' : 'Pause the weekly video');
    if (motionLabel) motionLabel.textContent = paused ? 'Play' : 'Pause';
  }

  function playIfAllowed() {
    if (manualPause || !inViewport || document.hidden || reducedMotion) return;
    var promise = video.play();
    if (promise && typeof promise.catch === 'function') {
      promise.catch(function () { refreshControl(); });
    }
  }

  function choose(index) {
    manualPause = true;
    video.pause();
    // Seek past the dissolve to a clean frame featuring the selected watch.
    var end = index === 6 ? fullDuration : starts[index + 1];
    video.currentTime = starts[index] + Math.min(0.37, Math.max(0.1, (end - starts[index]) / 3));
    paint(index, true);
    updateProgress();
    refreshControl();
  }

  tabs.forEach(function (tab, i) {
    tab.addEventListener('click', function () { choose(i); });
  });
  motion.addEventListener('click', function () {
    if (video.paused) {
      manualPause = false;
      playIfAllowed();
    } else {
      manualPause = true;
      video.pause();
    }
    refreshControl();
  });

  video.addEventListener('timeupdate', updateProgress);
  video.addEventListener('seeked', updateProgress);
  video.addEventListener('play', refreshControl);
  video.addEventListener('pause', refreshControl);
  video.addEventListener('loadedmetadata', function () {
    if (Number.isFinite(video.duration) && video.duration > 0) fullDuration = video.duration;
    if (reducedMotion) video.pause();
    updateProgress();
    refreshControl();
  });
  video.addEventListener('error', function () {
    video.pause();
    manualPause = true;
    refreshControl();
  });
  document.addEventListener('visibilitychange', function () {
    if (document.hidden) {
      wasPlaying = !video.paused;
      video.pause();
    } else if (wasPlaying) {
      playIfAllowed();
      wasPlaying = false;
    }
    refreshControl();
  });
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (entries) {
      if (!entries.length) return;
      inViewport = entries[0].isIntersecting;
      if (!inViewport) {
        wasPlaying = !video.paused;
        video.pause();
      } else if (wasPlaying) {
        playIfAllowed();
        wasPlaying = false;
      }
    }, {threshold: 0.1}).observe(hero);
  }
  hero.addEventListener('touchstart', function (event) {
    if (event.touches && event.touches.length === 1) {
      touchX = event.touches[0].clientX;
      touchY = event.touches[0].clientY;
    }
  }, {passive:true});
  hero.addEventListener('touchend', function (event) {
    if (touchX === null || !event.changedTouches || !event.changedTouches.length) return;
    var dx = event.changedTouches[0].clientX - touchX;
    var dy = event.changedTouches[0].clientY - touchY;
    touchX = null;
    touchY = null;
    if (Math.abs(dx) > 65 && Math.abs(dx) > Math.abs(dy) * 1.4) {
      choose((Math.max(active, 0) + (dx < 0 ? 1 : 6)) % 7);
    }
  }, {passive:true});
  hero.addEventListener('keydown', function (event) {
    if (!event.target.closest('[data-hero-tab]')) return;
    if (event.key !== 'ArrowRight' && event.key !== 'ArrowLeft') return;
    event.preventDefault();
    var next = (Math.max(active, 0) + (event.key === 'ArrowRight' ? 1 : 6)) % 7;
    choose(next);
    tabs[next].focus();
  });
  if (reducedMotion) {
    manualPause = true;
    video.pause();
  }
  paint(0, false);
  refreshControl();
  playIfAllowed();
})();