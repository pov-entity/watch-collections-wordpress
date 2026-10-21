/**
 * Seven-day editorial hero.
 * No animation libraries, network requests, cookies or customer data.
 * Manual selection stops autoplay so users can inspect each outfit.
 */
(function () {
  'use strict';

  var hero = document.querySelector('[data-week-hero]');
  if (!hero) return;

  var scenes = Array.prototype.slice.call(hero.querySelectorAll('[data-hero-scene]'));
  var tabs = Array.prototype.slice.call(hero.querySelectorAll('[data-hero-tab]'));
  var motion = hero.querySelector('[data-hero-motion]');
  var motionLabel = hero.querySelector('[data-hero-motion-label]');
  var count = hero.querySelector('[data-hero-count]');
  var day = hero.querySelector('[data-hero-day]');
  var moment = hero.querySelector('[data-hero-moment]');
  var style = hero.querySelector('[data-hero-style]');
  var announcer = hero.querySelector('[data-hero-announcer]');
  if (scenes.length !== 7 || tabs.length !== scenes.length || !motion) return;

  var reducedMotion = window.matchMedia
    ? window.matchMedia('(prefers-reduced-motion: reduce)')
    : null;
  var seconds = parseInt(hero.getAttribute('data-duration') || '3000', 10);
  var duration = Math.min(10000, Math.max(2500, isNaN(seconds) ? 3000 : seconds));
  var active = 0;
  var userPaused = Boolean(reducedMotion && reducedMotion.matches);
  var inViewport = true;
  var timerId = null;
  var touchX = null;
  var touchY = null;

  hero.style.setProperty('--hero-period', String(duration) + 'ms');

  function isAllowedToRun() {
    return !userPaused && inViewport && !document.hidden && !(reducedMotion && reducedMotion.matches);
  }

  function stopTimer() {
    if (timerId !== null) {
      window.clearTimeout(timerId);
      timerId = null;
    }
    hero.classList.remove('is-playing');
  }

  function refreshControl() {
    var paused = !isAllowedToRun();
    motion.setAttribute('aria-pressed', paused ? 'true' : 'false');
    motion.setAttribute('aria-label', paused ? 'Play the seven-day animation' : 'Pause the seven-day animation');
    if (motionLabel) motionLabel.textContent = paused ? 'Play' : 'Pause';
  }

  function paint(index, announce) {
    active = (index + scenes.length) % scenes.length;
    scenes.forEach(function (scene, i) {
      scene.classList.toggle('is-active', i === active);
    });
    tabs.forEach(function (tab, i) {
      var current = i === active;
      tab.classList.toggle('is-current', current);
      tab.setAttribute('aria-pressed', current ? 'true' : 'false');
    });

    var tab = tabs[active];
    count.textContent = String(active + 1).padStart(2, '0');
    day.textContent = tab.getAttribute('data-day') || '';
    moment.textContent = tab.getAttribute('data-moment') || '';
    style.textContent = tab.getAttribute('data-style') || '';

    // Automatic playback is decorative. Announce only intentional selections.
    if (announce && announcer) {
      announcer.textContent = day.textContent + ': ' + moment.textContent + ', ' + style.textContent;
    }
  }

  function startTimer() {
    stopTimer();
    if (!isAllowedToRun()) {
      refreshControl();
      return;
    }
    // Restart the progress bar after a day switch.
    void hero.offsetWidth;
    hero.classList.add('is-playing');
    refreshControl();
    timerId = window.setTimeout(function () {
      paint(active + 1, false);
      startTimer();
    }, duration);
  }

  function select(index) {
    userPaused = true;
    stopTimer();
    paint(index, true);
    refreshControl();
  }

  tabs.forEach(function (tab, i) {
    tab.addEventListener('click', function () { select(i); });
  });

  motion.addEventListener('click', function () {
    if (reducedMotion && reducedMotion.matches) return;
    userPaused = !userPaused;
    if (userPaused) {
      stopTimer();
      refreshControl();
    } else {
      startTimer();
    }
  });

  document.addEventListener('visibilitychange', function () {
    if (document.hidden) {
      stopTimer();
      refreshControl();
    } else {
      startTimer();
    }
  });

  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      if (!entries.length) return;
      inViewport = entries[0].isIntersecting;
      if (inViewport) startTimer();
      else {
        stopTimer();
        refreshControl();
      }
    }, { threshold: 0.1 });
    observer.observe(hero);
  }

  if (reducedMotion) {
    var motionListener = function (event) {
      if (event.matches) {
        userPaused = true;
        stopTimer();
        refreshControl();
      } else {
        // Stay paused until the visitor explicitly starts playback.
        refreshControl();
      }
    };
    if (typeof reducedMotion.addEventListener === 'function') {
      reducedMotion.addEventListener('change', motionListener);
    } else if (typeof reducedMotion.addListener === 'function') {
      reducedMotion.addListener(motionListener);
    }
  }

  // Swipe between days on a touchscreen, without hijacking vertical scrolling.
  hero.addEventListener('touchstart', function (event) {
    if (!event.touches || event.touches.length !== 1) return;
    touchX = event.touches[0].clientX;
    touchY = event.touches[0].clientY;
  }, { passive: true });

  hero.addEventListener('touchend', function (event) {
    if (touchX === null || !event.changedTouches || !event.changedTouches.length) return;
    var dx = event.changedTouches[0].clientX - touchX;
    var dy = event.changedTouches[0].clientY - touchY;
    touchX = null;
    touchY = null;
    if (Math.abs(dx) > 65 && Math.abs(dx) > Math.abs(dy) * 1.4) {
      select(active + (dx < 0 ? 1 : -1));
    }
  }, { passive: true });

  hero.addEventListener('keydown', function (event) {
    if (!event.target.closest('[data-hero-tab]')) return;
    if (event.key === 'ArrowRight') {
      event.preventDefault();
      select(active + 1);
      tabs[active].focus();
    } else if (event.key === 'ArrowLeft') {
      event.preventDefault();
      select(active - 1);
      tabs[active].focus();
    }
  });

  paint(0, false);
  startTimer();
})();
