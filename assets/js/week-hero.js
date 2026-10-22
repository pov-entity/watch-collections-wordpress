/**
 * Seven-day fashion hero with frame-specific clickable pause destinations.
 * Actual settled-pose timings determined from the 10s / 24fps source footage.
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
  var status = hero.querySelector('[data-hero-status]');
  var announcer = hero.querySelector('[data-hero-announcer]');
  if (!video || tabs.length !== 7 || !motion || !day || !count || !moment || !style) return;

  // Low-motion moments in the supplied Gemini video, in seconds:
  // Mon 0.67, Tue 2.25, Wed 3.75, Thu 5.21, Fri 6.63, Sat 7.71, Sun 9.13.
  var stopFrames = [0.667, 2.25, 3.75, 5.208, 6.625, 7.708, 9.125];
  // Scene boundaries are independent of the destination freeze frames.
  var boundaries = [0, 1.78, 3.08, 4.46, 5.88, 7.20, 8.65];
  var active = -1;
  var destination = -1;
  var needWrap = false;
  var hasWrapped = false;
  var lastTime = 0;
  var userPaused = false;
  var inViewport = true;
  var animationId = 0;
  var reducedMotionQuery = window.matchMedia ? window.matchMedia('(prefers-reduced-motion: reduce)') : null;
  var reducedMotion = Boolean(reducedMotionQuery && reducedMotionQuery.matches);
  var touchX = null;
  var touchY = null;

  function indexAt(time) {
    for (var i = boundaries.length - 1; i >= 0; i--) {
      if (time >= boundaries[i]) return i;
    }
    return 0;
  }

  function safeTime(index) {
    var limit = Number.isFinite(video.duration) && video.duration > 0 ? video.duration : 10;
    return Math.min(stopFrames[index], Math.max(0, limit - (1 / 24)));
  }

  function announceSelection() {
    if (announcer) announcer.textContent = day.textContent + ', ' + style.textContent + '. ' + moment.textContent;
  }

  function paint(index) {
    if (index === active) return;
    active = index;
    count.textContent = String(index + 1).padStart(2, '0');
    day.textContent = tabs[index].getAttribute('data-day') || '';
    style.textContent = tabs[index].getAttribute('data-style') || '';
    moment.textContent = tabs[index].getAttribute('data-moment') || '';
    tabs.forEach(function (tab, i) {
      tab.classList.toggle('is-current', index === i);
      tab.setAttribute('aria-pressed', index === i ? 'true' : 'false');
    });
  }

  function refresh() {
    var paused = video.paused;
    var movingToDay = destination >= 0 && !paused;
    hero.classList.toggle('is-playing', !paused);
    tabs.forEach(function (tab, i) {
      tab.classList.toggle('is-target', movingToDay && i === destination);
    });
    if (status) {
      status.textContent = movingToDay ? 'Moving to ' + (tabs[destination].getAttribute('data-day') || '') :
        paused ? 'Paused on this look' : 'Playing the week';
    }
    motion.setAttribute('aria-pressed', paused ? 'true' : 'false');
    motion.setAttribute('aria-label', paused ? 'Play the weekly video' : 'Pause the weekly video');
    if (motionLabel) motionLabel.textContent = paused ? 'Play' : 'Pause';
  }

  function stopAtDestination() {
    if (destination < 0) return;
    var i = destination;
    destination = -1;
    video.pause();
    video.currentTime = safeTime(i); // Exact settled frame, not a moving dissolve.
    lastTime = safeTime(i);
    paint(i);
    userPaused = true;
    refresh();
    announceSelection();
  }

  function tick() {
    animationId = 0;
    var time = video.currentTime || 0;
    if (time + 0.25 < lastTime) hasWrapped = true;
    lastTime = time;

    if (destination >= 0) {
      var stop = safeTime(destination);
      // Never pause on a dissolve or a moving pose: stop only at the recorded freeze frame.
      if ((!needWrap || hasWrapped) && time >= stop - 0.018) {
        stopAtDestination();
      } else {
        paint(indexAt(time));
      }
    } else if (!video.paused) {
      paint(indexAt(time));
    }
    if (!video.paused && animationId === 0) {
      animationId = window.requestAnimationFrame(tick);
    }
  }

  function startTicker() {
    if (!animationId) animationId = window.requestAnimationFrame(tick);
  }

  function seekAndHold(index) {
    // A reduced-motion preference skips the intervening video animation.
    destination = -1;
    video.pause();
    video.currentTime = safeTime(index);
    lastTime = safeTime(index);
    paint(index);
    userPaused = true;
    refresh();
    announceSelection();
  }

  function selectDay(index) {
    if (index === active && destination === -1) {
      seekAndHold(index);
      return;
    }
    if (reducedMotion) {
      seekAndHold(index);
      return;
    }
    var stop = safeTime(index);
    var now = video.currentTime || 0;
    needWrap = now >= stop - 0.018;
    hasWrapped = false;
    destination = index;
    userPaused = false;
    lastTime = now;

    // Play through the real outfit/watch transitions. If target is behind us,
    // let the source loop naturally instead of reverse-seeking through the footage.
    var playPromise = video.play();
    if (playPromise && typeof playPromise.catch === 'function') {
      playPromise.catch(function () { seekAndHold(index); });
    }
    startTicker();
    refresh();
  }

  function play() {
    destination = -1;
    needWrap = false;
    hasWrapped = false;
    userPaused = false;
    if (reducedMotion) return;
    var playPromise = video.play();
    if (playPromise && typeof playPromise.catch === 'function') {
      playPromise.catch(function () { refresh(); });
    }
    startTicker();
    refresh();
  }

  tabs.forEach(function (tab, index) {
    tab.addEventListener('click', function () { selectDay(index); });
  });

  motion.addEventListener('click', function () {
    if (video.paused) {
      play();
    } else {
      destination = -1;
      userPaused = true;
      video.pause();
      refresh();
    }
  });

  video.addEventListener('play', function () { startTicker(); refresh(); });
  video.addEventListener('pause', refresh);
  video.addEventListener('seeked', function () {
    if (destination === -1) {
      paint(indexAt(video.currentTime || 0));
      refresh();
    }
  });
  video.addEventListener('loadedmetadata', function () {
    if (reducedMotion) seekAndHold(0);
    else { paint(indexAt(video.currentTime || 0)); refresh(); }
  });
  video.addEventListener('error', function () {
    destination = -1;
    userPaused = true;
    refresh();
  });

  document.addEventListener('visibilitychange', function () {
    if (document.hidden) {
      video.pause();
    } else if (!userPaused && inViewport && !reducedMotion) {
      // Retain an active navigation destination after the user changes tabs.
      var promise = video.play();
      if (promise && promise.catch) promise.catch(function () {});
      startTicker();
    }
    refresh();
  });

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (entries) {
      if (!entries.length) return;
      inViewport = entries[0].isIntersecting;
      if (!inViewport) {
        video.pause();
      } else if (!userPaused && !document.hidden && !reducedMotion) {
        var promise = video.play();
        if (promise && promise.catch) promise.catch(function () {});
        startTicker();
      }
    }, {threshold: 0.1}).observe(hero);
  }

  if (reducedMotionQuery) {
    var updateMotionPreference = function (event) {
      reducedMotion = event.matches;
      if (reducedMotion) seekAndHold(Math.max(0, active));
    };
    if (reducedMotionQuery.addEventListener) reducedMotionQuery.addEventListener('change', updateMotionPreference);
    else if (reducedMotionQuery.addListener) reducedMotionQuery.addListener(updateMotionPreference);
  }

  hero.addEventListener('touchstart', function (event) {
    if (!event.touches || event.touches.length !== 1) return;
    touchX = event.touches[0].clientX;
    touchY = event.touches[0].clientY;
  }, {passive:true});
  hero.addEventListener('touchend', function (event) {
    if (touchX === null || !event.changedTouches || !event.changedTouches.length) return;
    var dx = event.changedTouches[0].clientX - touchX;
    var dy = event.changedTouches[0].clientY - touchY;
    touchX = null;
    touchY = null;
    if (Math.abs(dx) > 65 && Math.abs(dx) > Math.abs(dy) * 1.4) {
      selectDay((Math.max(0, active) + (dx < 0 ? 1 : 6)) % 7);
    }
  }, {passive:true});
  hero.addEventListener('keydown', function (event) {
    if (!event.target.closest('[data-hero-tab]')) return;
    if (event.key !== 'ArrowRight' && event.key !== 'ArrowLeft') return;
    event.preventDefault();
    var target = (Math.max(0, active) + (event.key === 'ArrowRight' ? 1 : 6)) % 7;
    selectDay(target);
    tabs[target].focus();
  });

  paint(0);
  if (reducedMotion) seekAndHold(0);
  else { startTicker(); refresh(); }
})();
