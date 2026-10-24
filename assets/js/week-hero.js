/** Video-derived day previews, immediate muted autoplay, and matched day reveals. */
(function () {
  'use strict';
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');

  function prepare(video) {
    video.muted = true;
    video.defaultMuted = true;
    video.playsInline = true;
    video.setAttribute('muted', '');
    video.setAttribute('playsinline', '');
    video.setAttribute('webkit-playsinline', '');
    video.controls = false;
  }

  // The assembly loop has its own pause control and only runs while visible.
  var assembly = document.querySelector('[data-assembly-video]');
  var assemblyButton = document.querySelector('[data-assembly-motion]');
  if (assembly && assemblyButton) {
    var assemblyPausedByUser = false;
    var assemblyVisible = false;
    prepare(assembly);
    function assemblyState() {
      assemblyButton.setAttribute('aria-pressed', assembly.paused ? 'true' : 'false');
      assemblyButton.setAttribute('aria-label', assembly.paused ? 'Play watch assembly animation' : 'Pause watch assembly animation');
      assemblyButton.textContent = assembly.paused ? 'Play animation' : 'Pause animation';
    }
    function playAssembly() {
      if (document.hidden || !assemblyVisible || assemblyPausedByUser || reduce.matches) return;
      var p = assembly.play();
      if (p && p.catch) p.catch(assemblyState);
    }
    assemblyButton.addEventListener('click', function () {
      assemblyPausedByUser = !assembly.paused;
      if (assembly.paused) {
        var p = assembly.play();
        if (p && p.catch) p.catch(assemblyState);
      } else assembly.pause();
      assemblyState();
    });
    assembly.addEventListener('play', assemblyState);
    assembly.addEventListener('pause', assemblyState);
    assembly.addEventListener('canplay', playAssembly);
    assembly.addEventListener('error', function () { assemblyState(); });
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (entries) {
        assemblyVisible = entries[0].isIntersecting;
        if (assemblyVisible) playAssembly(); else assembly.pause();
      }, {threshold: 0.12}).observe(assembly);
    } else { assemblyVisible = true; playAssembly(); }
    document.addEventListener('visibilitychange', function () {
      if (document.hidden) assembly.pause(); else playAssembly();
    });
    reduce.addEventListener('change', function () {
      if (reduce.matches) assembly.pause(); else playAssembly();
    });
    assemblyState();
  }

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
  var images = Array.prototype.slice.call(hero.querySelectorAll('[data-hero-fallback-image]'));
  if (!video || tabs.length !== 7 || !motion || !day || !count || !moment || !style) return;
  prepare(video);

  var stops = [0.667, 2.25, 3.75, 5.208, 6.625, 7.708, 9.125];
  var boundaries = [0, 1.78, 3.08, 4.46, 5.88, 7.20, 8.65];
  var active = -1;
  var destination = -1;
  var switching = false;
  var switchSerial = 0;
  var userPaused = false;
  var inViewport = true;
  var blocked = false;
  var hasPlayed = false;
  var pendingDay = -1;
  var animationId = 0;
  var touchX = null;
  var touchY = null;
  var videoError = video.getAttribute('data-video-available') === '0';

  function indexAt(time) {
    for (var i = boundaries.length - 1; i >= 0; i--) if (time >= boundaries[i]) return i;
    return 0;
  }
  function safeTime(index) {
    var duration = Number.isFinite(video.duration) && video.duration > 0 ? video.duration : 10;
    return Math.min(stops[index], Math.max(0, duration - 1 / 24));
  }
  function announce() {
    if (announcer) announcer.textContent = day.textContent + ', ' + style.textContent + '. ' + moment.textContent;
  }
  // Secondary still frames are fetched only when needed for a seek or fallback.
  // The playing film does not trigger seven competing full-image downloads.
  function loadFrame(index) {
    var image = images[index];
    if (!image) return;
    var deferred = image.getAttribute('data-src');
    if (deferred) {
      image.src = deferred;
      image.removeAttribute('data-src');
    }
  }
  function paint(index) {
    if (index === active) return;
    active = index;
    if (videoError || switching || !hasPlayed) loadFrame(index);
    // Every fallback is extracted from this exact video's settled frame.
    images.forEach(function (image, i) { image.classList.toggle('is-active', i === index); });
    count.textContent = String(index + 1).padStart(2, '0');
    day.textContent = tabs[index].getAttribute('data-day') || '';
    style.textContent = tabs[index].getAttribute('data-style') || '';
    moment.textContent = tabs[index].getAttribute('data-moment') || '';
    tabs.forEach(function (tab, i) {
      tab.classList.toggle('is-current', i === index);
      tab.setAttribute('aria-pressed', i === index ? 'true' : 'false');
    });
  }
  function refresh() {
    var paused = videoError || video.paused;
    hero.classList.toggle('is-playing', !paused);
    hero.classList.toggle('is-autoplay-blocked', blocked);
    tabs.forEach(function (tab, i) { tab.classList.toggle('is-target', destination === i); });
    motion.setAttribute('aria-pressed', paused ? 'true' : 'false');
    motion.setAttribute('aria-label', paused ? 'Play the weekly video' : 'Pause at the next still pose');
    if (motionLabel) motionLabel.textContent = paused ? 'Play' : 'Pause';
    if (status) status.textContent = videoError ? 'Video unavailable — showing the matching watch frame' :
      blocked ? 'Tap Play to start the muted video' : switching ? 'Loading the selected look' :
      destination >= 0 ? 'Moving to ' + tabs[destination].getAttribute('data-day') :
      paused ? 'Paused on this look' : 'Playing the week';
  }
  function ticker() {
    animationId = 0;
    if (!switching && !video.seeking) {
      var time = video.currentTime || 0;
      if (destination >= 0 && time >= safeTime(destination) - 0.018) {
        var index = destination;
        destination = -1;
        userPaused = true;
        video.pause();
        video.currentTime = safeTime(index);
        paint(index);
        refresh();
        announce();
      } else if (destination < 0 && !video.paused) paint(indexAt(time));
    }
    if (!video.paused) startTicker();
  }
  function startTicker() {
    if (!animationId) animationId = window.requestAnimationFrame(ticker);
  }
  function hold(index) {
    switchSerial++;
    destination = -1;
    switching = false;
    userPaused = true;
    video.pause();
    paint(index);
    // Keep the matching extracted frame visible until seeking has completed.
    hero.classList.add('is-switching');
    if (video.readyState >= 1) video.currentTime = safeTime(index);
    else pendingDay = index;
    refresh();
    announce();
  }
  function selectDay(index) {
    if (videoError) { userPaused = true; paint(index); refresh(); announce(); return; }
    if (video.readyState < 1) { pendingDay = index; paint(index); refresh(); return; }
    if (reduce.matches || (index === active && video.paused && !blocked)) { hold(index); return; }
    var serial = ++switchSerial;
    // Jump directly to the final clean movement of the requested scene. The
    // matching extracted watch frame masks the seek, so no other day flashes.
    destination = index;
    switching = true;
    blocked = false;
    userPaused = false;
    hero.classList.add('is-switching');
    paint(index);
    video.pause();
    video.currentTime = Math.max(boundaries[index], safeTime(index) - 0.20);
    var p = video.play();
    if (p && p.catch) p.catch(function () {
      if (serial !== switchSerial) return;
      blocked = true;
      hold(index);
    });
    startTicker();
    refresh();
  }
  function attemptAutoplay() {
    if (videoError || userPaused || document.hidden || !inViewport || reduce.matches) return;
    prepare(video);
    var serial = switchSerial;
    var p = video.play();
    if (p && p.catch) p.catch(function () {
      if (serial !== switchSerial || userPaused) return;
      blocked = true;
      refresh();
    });
    startTicker();
  }
  function resume() {
    switchSerial++;
    destination = -1;
    switching = false;
    userPaused = false;
    blocked = false;
    hero.classList.remove('is-switching');
    // An explicit gesture can start playback even with a motion preference.
    var serial = switchSerial;
    var p = video.play();
    if (p && p.catch) p.catch(function () {
      if (serial !== switchSerial) return;
      blocked = true;
      refresh();
    });
    startTicker();
    refresh();
  }
  tabs.forEach(function (tab, index) { tab.addEventListener('click', function () { selectDay(index); }); });
  motion.addEventListener('click', function () {
    if (videoError) { refresh(); return; }
    if (video.paused) resume();
    else {
      var next = stops.findIndex(function (time) { return time > video.currentTime + 0.05; });
      if (next < 0) hold(6);
      else { destination = next; switching = false; startTicker(); refresh(); }
    }
  });
  video.addEventListener('playing', function () {
    hasPlayed = true;
    blocked = false;
    hero.classList.add('has-started');
    startTicker();
    refresh();
  });
  video.addEventListener('play', function () { startTicker(); refresh(); });
  video.addEventListener('pause', refresh);
  video.addEventListener('seeked', function () {
    var serial = switchSerial;
    var reveal = function () {
      if (serial !== switchSerial || video.seeking) return;
      switching = false;
      if (hasPlayed && !blocked) hero.classList.remove('is-switching');
      if (destination < 0) paint(indexAt(video.currentTime || 0));
      startTicker();
      refresh();
    };
    // rAF lets the newly decoded frame replace the previous texture first.
    window.requestAnimationFrame(reveal);
  });
  video.addEventListener('loadedmetadata', function () {
    if (pendingDay >= 0) {
      var index = pendingDay;
      pendingDay = -1;
      if (reduce.matches || userPaused) hold(index); else selectDay(index);
    } else if (reduce.matches) hold(0);
    else attemptAutoplay();
  });
  video.addEventListener('loadeddata', attemptAutoplay);
  video.addEventListener('canplay', attemptAutoplay);
  video.addEventListener('error', function () {
    videoError = true;
    destination = -1;
    switching = false;
    hero.classList.add('has-video-error');
    refresh();
  });
  // Safari may refuse autoplay in Low Power Mode. Retry on a real interaction;
  // never replace it with a misleading unrelated photograph or native overlay.
  function gestureRetry(event) {
    if (!blocked || userPaused || reduce.matches || event.target.closest('[data-hero-tab],[data-hero-motion]')) return;
    attemptAutoplay();
  }
  document.addEventListener('pointerdown', gestureRetry, {passive:true});
  document.addEventListener('touchend', gestureRetry, {passive:true});
  document.addEventListener('keydown', gestureRetry);
  document.addEventListener('visibilitychange', function () {
    if (document.hidden) video.pause(); else attemptAutoplay();
    refresh();
  });
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (entries) {
      inViewport = entries[0].isIntersecting;
      if (!inViewport) video.pause(); else attemptAutoplay();
    }, {threshold: 0.1}).observe(hero);
  }
  reduce.addEventListener('change', function () {
    if (reduce.matches) hold(Math.max(0, active)); else { userPaused = false; attemptAutoplay(); }
  });
  hero.addEventListener('touchstart', function (event) {
    if (event.target.closest('button, a') || event.touches.length !== 1) { touchX = null; return; }
    touchX = event.touches[0].clientX;
    touchY = event.touches[0].clientY;
  }, {passive:true});
  hero.addEventListener('touchend', function (event) {
    if (touchX === null || !event.changedTouches.length) return;
    var dx = event.changedTouches[0].clientX - touchX;
    var dy = event.changedTouches[0].clientY - touchY;
    touchX = null;
    touchY = null;
    if (Math.abs(dx) > 65 && Math.abs(dx) > Math.abs(dy) * 1.4) selectDay((Math.max(0, active) + (dx < 0 ? 1 : 6)) % 7);
  }, {passive:true});
  hero.addEventListener('keydown', function (event) {
    if (!event.target.closest('[data-hero-tab]') || ['ArrowLeft', 'ArrowRight'].indexOf(event.key) < 0) return;
    event.preventDefault();
    var target = (Math.max(0, active) + (event.key === 'ArrowRight' ? 1 : 6)) % 7;
    selectDay(target);
    tabs[target].focus();
  });
  paint(0);
  refresh();
  if (reduce.matches) hold(0); else attemptAutoplay();
})();


// A localized material reflection; normal link activation stays immediate.
(function () {
  'use strict';
  var invitation = document.querySelector('[data-precious-cta]');
  if (!invitation || !('PointerEvent' in window)) return;
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
  function reflect(event) {
    var rect = invitation.getBoundingClientRect();
    if (!rect.width || !rect.height) return;
    var x = Math.max(0, Math.min(100, (event.clientX - rect.left) / rect.width * 100));
    var y = Math.max(0, Math.min(100, (event.clientY - rect.top) / rect.height * 100));
    invitation.style.setProperty('--touch-x', x.toFixed(2) + '%');
    invitation.style.setProperty('--touch-y', y.toFixed(2) + '%');
  }
  invitation.addEventListener('pointerdown', reflect, {passive:true});
  invitation.addEventListener('pointermove', function (event) {
    if (!reduced.matches && event.pointerType === 'mouse') reflect(event);
  }, {passive:true});
})();
