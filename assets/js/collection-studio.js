(function () {
  'use strict';
  const root = document.querySelector('[data-collection-studio]');
  if (!root || !window.DialByDayCollection) return;
  const config = JSON.parse(root.querySelector('[data-studio-config]').textContent);
  const model = window.DialByDayCollection.createModel(config.watches, config.packages);
  const watches = new Map(config.watches.map(watch => [watch.id, watch]));
  const storageKey = 'dialbyday.collection.v1';
  const query = new URLSearchParams(window.location.search);
  const requestedSize = Number(query.get('box'));
  let saved = null;
  try { saved = window.localStorage.getItem(storageKey); } catch (_) { /* Private mode: keep selections in memory. */ }
  let state = model.hydrate(saved, model.validSize(requestedSize) ? requestedSize : config.defaultSize);
  let storageAvailable = false;
  let filter = 'all';
  let search = '';
  let strap = 'all';
  let motion = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  let svgId = 0;
  let toastTimer;
  let dialogOpener;
  let carouselWatches = [];
  let activeWatchId = (config.watches[1] || config.watches[0] || {}).id;
  let carouselTarget = null;
  let scrollFrame;
  let centerFrame;
  let scrollTimer;
  const dialog = root.querySelector('[data-studio-dialog]');
  const dialogContent = root.querySelector('[data-dialog-content]');
  const track = root.querySelector('[data-watch-track]');
  const $ = selector => root.querySelector(selector);
  const escape = value => String(value).replace(/[&<>"']/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[char]));
  const money = value => value === null ? 'Price to be confirmed' : '$' + value.toLocaleString('en-US');
  const colour = (value, fallback) => /^#[0-9a-f]{6}$/i.test(value || '') ? value : fallback;

  /** Original vector concepts. No product or material specification is implied. */
  function watchArt(watch, overhead) {
    const id = 'studio-watch-' + (++svgId);
    const palette = watch.palette || {};
    const dial = colour(palette.dial, '#163754');
    const edge = colour(palette.edge, '#0A1929');
    const metal = colour(palette.metal, '#B9C9D4');
    const band = colour(palette.strap, '#879BA9');
    const mark = colour(palette.mark, '#EDF3F5');
    const metalBand = watch.strap === 'bracelet';
    let bandDetails = '';
    if (metalBand) {
      for (let y = 17; y < 303; y += 13) bandDetails += `<path d="M85 ${y}h70" stroke="#152631" stroke-opacity=".4"/><path d="M97 ${y + 2}h46" stroke="#FFFFFF" stroke-opacity=".3"/><path d="M100 ${y}v12m40-12v12" stroke="#152631" stroke-opacity=".28"/>`;
    } else if (watch.strap === 'sport') {
      for (let y = 27; y < 300; y += 15) bandDetails += `<path d="M90 ${y}h60" stroke="#0A1721" stroke-opacity=".4"/><rect x="116" y="${y + 3}" width="8" height="5" rx="2" fill="#0A1721" fill-opacity=".4"/>`;
    } else {
      bandDetails = '<path d="M88 28v255m64-255v255" stroke="#D3C5AD" stroke-opacity=".5" stroke-dasharray="3 4"/>';
      for (let y = 235; y < 293; y += 13) bandDetails += `<circle cx="120" cy="${y}" r="2" fill="#10191E" fill-opacity=".6"/>`;
    }
    let marks = '';
    for (let i = 0; i < 60; i++) {
      const major = i % 5 === 0;
      marks += `<path d="M120 103v${major ? 9 : 3}" transform="rotate(${i * 6} 120 155)" stroke="${mark}" stroke-width="${major ? 2.4 : .65}" stroke-opacity="${major ? .95 : .58}"/>`;
    }
    let complication = '';
    if (watch.style === 'chronograph') {
      [[96, 150], [144, 150], [120, 178]].forEach(([x, y]) => { complication += `<circle cx="${x}" cy="${y}" r="12" fill="${edge}" fill-opacity=".55" stroke="${mark}" stroke-opacity=".3"/><circle cx="${x}" cy="${y}" r="9" fill="none" stroke="${mark}" stroke-opacity=".2" stroke-dasharray="1 3"/><path d="M${x} ${y + 4}v-12" stroke="${mark}" stroke-width="1"/>`; });
    } else if (watch.style === 'moonphase') {
      complication = `<path d="M96 171a24 24 0 0 1 48 0Z" fill="#10233E" stroke="${metal}" stroke-opacity=".6"/><path d="M119 150a8 8 0 1 0 9 10 7 7 0 0 1-9-10Z" fill="#D9C391"/><circle cx="106" cy="165" r="1" fill="#E3D5B0"/><circle cx="133" cy="159" r="1" fill="#E3D5B0"/>`;
    } else if (watch.style === 'skeleton') {
      [[101, 143, 15], [137, 169, 19], [104, 177, 10]].forEach(([x, y, radius]) => {
        complication += `<circle cx="${x}" cy="${y}" r="${radius}" fill="${edge}" stroke="${metal}" stroke-width="3" stroke-dasharray="3 2"/><circle cx="${x}" cy="${y}" r="${radius - 5}" fill="none" stroke="${metal}" stroke-opacity=".7"/><path d="M${x - radius + 4} ${y}h${radius * 2 - 8}m-${radius - 4} -${radius - 4}v${radius * 2 - 8}" stroke="${metal}" stroke-width="2"/>`;
      });
      complication += `<path d="m93 117 55 70m-62-12 64-42" stroke="${metal}" stroke-opacity=".65" stroke-width="4"/>`;
    } else {
      complication = `<rect x="143" y="150" width="13" height="10" rx="1" fill="${mark}" fill-opacity=".9"/><text x="149.5" y="157.5" text-anchor="middle" font-size="6.5" font-family="Arial" fill="${edge}">21</text>`;
    }
    const sportBezel = watch.style === 'sport' ? `<circle cx="120" cy="155" r="59" fill="none" stroke="${edge}" stroke-width="9"/><path d="m120 93-3 6h6Z" fill="${mark}"/><circle cx="174" cy="155" r="1.4" fill="${mark}"/><circle cx="66" cy="155" r="1.4" fill="${mark}"/>` : '';
    return `<svg class="studio-watch-art${overhead ? ' studio-watch-art--overhead' : ''}" viewBox="${overhead ? '45 26 150 258' : '0 0 240 320'}" fill="none" aria-hidden="true" focusable="false"><defs><linearGradient id="${id}-band" x1="80" y1="0" x2="159" y2="0" gradientUnits="userSpaceOnUse"><stop stop-color="${band}"/><stop offset=".3" stop-color="${band}"/><stop offset=".5" stop-color="${metalBand ? metal : band}"/><stop offset="1" stop-color="${band}"/></linearGradient><linearGradient id="${id}-metal" x1="64" y1="100" x2="180" y2="216" gradientUnits="userSpaceOnUse"><stop stop-color="#F8FAFB"/><stop offset=".18" stop-color="${metal}"/><stop offset=".4" stop-color="#62717A"/><stop offset=".53" stop-color="${metal}"/><stop offset=".8" stop-color="#EEF3F5"/><stop offset="1" stop-color="${metal}"/></linearGradient><radialGradient id="${id}-dial"><stop stop-color="${dial}"/><stop offset="1" stop-color="${edge}"/></radialGradient><linearGradient id="${id}-glass" x1="72" y1="97" x2="161" y2="211" gradientUnits="userSpaceOnUse"><stop stop-color="#FFFFFF" stop-opacity=".21"/><stop offset=".5" stop-color="#FFFFFF" stop-opacity="0"/><stop offset="1" stop-color="#FFFFFF" stop-opacity=".07"/></linearGradient><clipPath id="${id}-clip"><rect x="83" y="9" width="74" height="300" rx="16"/></clipPath></defs><ellipse cx="123" cy="302" rx="57" ry="7" fill="#102A4F" fill-opacity=".12"/><rect x="83" y="9" width="74" height="300" rx="16" fill="url(#${id}-band)" stroke="${edge}" stroke-opacity=".2"/><g clip-path="url(#${id}-clip)">${bandDetails}</g><path d="m78 104 5-25h16v27m42 0V79h16l5 25M78 205l5 25h16v-27m42 0v27h16l5-25" fill="url(#${id}-metal)"/><rect x="179" y="147" width="12" height="17" rx="4" fill="url(#${id}-metal)"/><path d="M183 149v13m3-13v13" stroke="${edge}" stroke-opacity=".4"/>${watch.style === 'chronograph' ? `<rect x="173" y="116" width="11" height="9" rx="3" fill="${metal}"/><rect x="173" y="186" width="11" height="9" rx="3" fill="${metal}"/>` : ''}<circle cx="120" cy="158" r="66" fill="#071724" fill-opacity=".22"/><circle cx="120" cy="155" r="65" fill="url(#${id}-metal)" stroke="${metal}" stroke-width="1.4"/><circle cx="120" cy="155" r="58" fill="url(#${id}-dial)" stroke="${edge}" stroke-width="2"/>${sportBezel}<g${watch.style === 'sport' ? ' transform="translate(120 155) scale(.9) translate(-120 -155)"' : ''}>${marks}${complication}<path d="M120 155 100 128" stroke="#071724" stroke-width="5" stroke-linecap="round"/><path d="M120 155 100 128" stroke="${mark}" stroke-width="3.4" stroke-linecap="round"/><path d="M120 155 153 132" stroke="#071724" stroke-width="4" stroke-linecap="round"/><path d="M120 155 153 132" stroke="${mark}" stroke-width="2.4" stroke-linecap="round"/><path d="m115 176 17-71" stroke="${watch.style === 'sport' ? '#D68C68' : metal}" stroke-width=".9"/><circle cx="120" cy="155" r="3.2" fill="${metal}"/><circle cx="120" cy="155" r="1.1" fill="${edge}"/></g><circle cx="120" cy="155" r="56" fill="url(#${id}-glass)"/><path d="M79 124a49 49 0 0 1 60-15" stroke="#FFFFFF" stroke-opacity=".28" stroke-width="1.1"/></svg>`;
  }

  function notify(message) {
    const toast = $('[data-studio-toast]');
    clearTimeout(toastTimer);
    toast.textContent = message;
    toast.classList.add('is-visible');
    toastTimer = setTimeout(() => toast.classList.remove('is-visible'), 4200);
  }
  function save() {
    try { window.localStorage.setItem(storageKey, model.serialize(state)); storageAvailable = true; }
    catch (_) { storageAvailable = false; }
  }
  function restoreFocus(key) {
    if (!key) return;
    const element = root.querySelector(key);
    if (element) element.focus({ preventScroll: true });
  }
  function carouselSlide(watch, index, total) {
    return `<div class="studio-carousel-slide" data-carousel-slide data-id="${escape(watch.id)}" role="group" aria-roledescription="slide" aria-label="${index + 1} of ${total}: ${escape(watch.name)}"><button type="button" class="studio-carousel-visual" data-action="focus-watch" data-id="${escape(watch.id)}" aria-label="Choose ${escape(watch.name)}" aria-pressed="false" tabindex="-1">${watchArt(watch)}<span class="studio-carousel-selected" hidden><span aria-hidden="true">✓</span> In your box</span></button></div>`;
  }
  function renderFeatured(watch) {
    const selected = state.slots.includes(watch.id);
    const label = selected ? 'In your box' : (state.target !== null ? 'Replace watch' : (model.count(state) === state.size ? 'Swap into box' : 'Add to my box'));
    $('[data-watch-feature]').innerHTML = `<p class="studio-feature-style">${escape(watch.styleLabel)}<span>Concept ${String(config.watches.indexOf(watch) + 1).padStart(2, '0')}</span></p><h3 id="studio-feature-title">${escape(watch.name)}</h3><p class="studio-feature-description">${escape(watch.description)}</p><dl class="studio-feature-specs"><div><dt>Dial</dt><dd>${escape(watch.dial)}</dd></div><div><dt>Finish</dt><dd>${escape(watch.finish)}</dd></div><div><dt>Strap design</dt><dd>${escape(watch.strapLabel)}</dd></div></dl><div class="studio-feature-actions"><button type="button" class="studio-primary studio-feature-add${selected ? ' is-in-box' : ''}" data-feature-add data-action="${selected ? 'review' : 'add'}" data-id="${escape(watch.id)}" aria-label="${escape(label + ': ' + watch.name)}">${label}<span aria-hidden="true">${selected ? '✓' : '+'}</span></button><button type="button" class="studio-feature-details" data-action="details" data-id="${escape(watch.id)}">View full details <span aria-hidden="true">↗</span></button></div>`;
  }
  function setActiveWatch(id, refresh) {
    const index = carouselWatches.findIndex(watch => watch.id === id);
    if (index < 0) return;
    const changed = activeWatchId !== id;
    if (!changed && !refresh) return;
    activeWatchId = id;
    track.querySelectorAll('[data-carousel-slide]').forEach(slide => {
      const active = slide.dataset.id === id;
      slide.classList.toggle('is-active', active);
      const button = slide.querySelector('button');
      button.setAttribute('aria-pressed', String(active));
      button.tabIndex = active ? 0 : -1;
    });
    $('[data-action="previous-watch"]').disabled = index === 0;
    $('[data-action="next-watch"]').disabled = index === carouselWatches.length - 1;
    $('[data-carousel-position]').textContent = String(index + 1).padStart(2, '0') + ' / ' + String(carouselWatches.length).padStart(2, '0');
    $('[data-carousel-announcement]').textContent = ': ' + carouselWatches[index].name;
    $('[data-carousel-progress]').style.width = ((index + 1) / carouselWatches.length * 100) + '%';
    if (changed || refresh) renderFeatured(carouselWatches[index]);
  }
  function nearestWatch() {
    if (!carouselWatches.length || carouselTarget) return;
    const center = track.getBoundingClientRect().left + track.clientWidth / 2;
    let nearest = null;
    let distance = Infinity;
    track.querySelectorAll('[data-carousel-slide]').forEach(slide => {
      const rect = slide.getBoundingClientRect();
      const offset = Math.abs(rect.left + rect.width / 2 - center);
      if (offset < distance) { distance = offset; nearest = slide.dataset.id; }
    });
    if (nearest) setActiveWatch(nearest);
  }
  function settleCarousel() {
    clearTimeout(scrollTimer);
    carouselTarget = null;
    nearestWatch();
  }
  function centerWatch(id, animate) {
    const slide = track.querySelector(`[data-carousel-slide][data-id="${id}"]`);
    if (!slide) return;
    setActiveWatch(id);
    carouselTarget = id;
    const offset = slide.offsetLeft + slide.offsetWidth / 2 - track.clientWidth / 2;
    track.scrollTo({ left: offset, behavior: animate && motion ? 'smooth' : 'instant' });
    clearTimeout(scrollTimer);
    scrollTimer = setTimeout(settleCarousel, 160);
  }
  function moveCarousel(direction) {
    const index = carouselWatches.findIndex(watch => watch.id === activeWatchId);
    const next = carouselWatches[index + direction];
    if (next) centerWatch(next.id, true);
  }
  function renderCatalog() {
    const list = config.watches.filter(watch => {
      const text = [watch.name, watch.styleLabel, watch.dial, watch.strapLabel, watch.finish].join(' ').toLowerCase();
      return (filter === 'all' || watch.style === filter) && (strap === 'all' || watch.strap === strap) && (!search || text.includes(search));
    });
    const changed = list.map(watch => watch.id).join() !== carouselWatches.map(watch => watch.id).join();
    carouselWatches = list;
    if (!list.some(watch => watch.id === activeWatchId)) activeWatchId = list.length ? list[0].id : null;
    $('[data-watch-carousel]').hidden = list.length === 0;
    if (changed) {
      cancelAnimationFrame(scrollFrame);
      cancelAnimationFrame(centerFrame);
      clearTimeout(scrollTimer);
      carouselTarget = null;
      track.innerHTML = list.map((watch, index) => carouselSlide(watch, index, list.length)).join('');
    }
    track.querySelectorAll('[data-carousel-slide]').forEach(slide => {
      const selected = state.slots.includes(slide.dataset.id);
      slide.classList.toggle('is-selected', selected);
      slide.querySelector('.studio-carousel-selected').hidden = !selected;
    });
    if (list.length) {
      setActiveWatch(activeWatchId, true);
      if (changed) centerFrame = requestAnimationFrame(() => centerWatch(activeWatchId, false));
    }
    $('[data-result-count]').textContent = list.length + ' concept ' + (list.length === 1 ? 'watch' : 'watches') + (filter === 'all' && strap === 'all' && !search ? ' · Find your next favourite.' : ' found');
    $('[data-catalog-empty]').hidden = list.length > 0;
    $('[data-action="reset-filters"]').hidden = filter === 'all' && strap === 'all' && !search;
    root.querySelectorAll('[data-action="filter"]').forEach(button => button.setAttribute('aria-pressed', String(button.dataset.style === filter)));
    const notice = $('[data-replace-notice]');
    notice.hidden = state.target === null;
    notice.innerHTML = state.target === null ? '' : `<span>Choose a watch for slot ${state.target + 1}${state.slots[state.target] ? ', replacing ' + escape(watches.get(state.slots[state.target]).name) : ''}.</span><button type="button" class="studio-quiet-button" data-action="cancel-replace">Cancel</button>`;
  }
  function traySlots() {
    return state.slots.map((id, index) => `<button type="button" class="studio-slot${id ? ' is-filled' : ''}${state.target === index ? ' is-target' : ''}" data-action="slot" data-slot="${index}" aria-label="${id ? 'Edit slot ' + (index + 1) + ': ' + escape(watches.get(id).name) : 'Choose a watch for empty slot ' + (index + 1)}">${id ? watchArt(watches.get(id), true) : '<span class="studio-slot-plus" aria-hidden="true">+</span>'}<span class="studio-slot-number">${String(index + 1).padStart(2, '0')}</span></button>`).join('');
  }
  function prepareOverheadImages() {
    root.querySelectorAll('.studio-box-overhead__image').forEach(image => {
      const reveal = () => image.parentElement.classList.add('is-ready');
      if (image.complete && image.naturalWidth > 0) reveal();
      else image.addEventListener('load', reveal, { once: true });
    });
  }
  function boxMarkup() {
    const box = config.boxes && config.boxes[state.size];
    if (!box) return `<div class="studio-box" data-box-tray role="group" aria-label="Your presentation box preview">${traySlots()}</div>`;
    const [x, y, width, height] = box.frame;
    const [left, top, areaWidth, areaHeight] = box.area;
    const style = [
      '--box-ratio:' + width + '/' + height,
      '--box-columns:' + state.size,
      '--box-image-width:' + (box.width / width * 100) + '%',
      '--box-image-left:' + (-x / width * 100) + '%',
      '--box-image-top:' + (-y / height * 100) + '%',
      '--box-left:' + ((left - x) / width * 100) + '%',
      '--box-top:' + ((top - y) / height * 100) + '%',
      '--box-right:' + ((x + width - left - areaWidth) / width * 100) + '%',
      '--box-bottom:' + ((y + height - top - areaHeight) / height * 100) + '%',
      '--box-gap:' + (box.gap / areaWidth * 100) + '%'
    ].join(';');
    return `<div class="studio-box-overhead" data-tray-size="${state.size}" style="${style}"><img class="studio-box-overhead__image" src="${escape(box.src)}" srcset="${escape(box.small)} ${box.smallWidth}w, ${escape(box.src)} ${box.width}w" sizes="${state.size === 1 ? '200px' : '(max-width: 700px) 94vw, 760px'}" width="${box.width}" height="${box.height}" alt="" decoding="async" draggable="false"><div class="studio-box" data-box-tray role="group" aria-label="Overhead view of your ${state.size}-watch presentation box">${traySlots()}</div></div>`;
  }
  function renderBox() {
    const count = model.count(state);
    const price = model.price(state);
    root.dataset.size = state.size;
    $('[data-box-count]').textContent = count + ' / ' + state.size;
    $('[data-box-display]').innerHTML = boxMarkup();
    prepareOverheadImages();
    $('[data-box-progress]').style.width = (count / state.size * 100) + '%';
    $('[data-box-hint]').textContent = count === 0 ? 'Your first choice sets the tone. Start with a watch that feels like you.' : count === state.size ? 'All together. Tap any watch to change it, or see your complete collection.' : (state.size - count) + ' more to make it yours. Mix styles, or stay with a look you love.';
    $('[data-box-price]').textContent = money(price);
    $('[data-box-price]').classList.toggle('is-pending', price === null);
    $('[data-box-inclusions]').textContent = state.size + (state.size === 1 ? ' watch' : ' watches') + ' + presentation box';
    $('[data-save-status]').textContent = storageAvailable ? 'Saved on this device' : 'Kept for this visit';
    $('[data-action="clear"]').disabled = count === 0;
    root.querySelectorAll('[data-action="size"]').forEach(button => button.setAttribute('aria-pressed', String(Number(button.dataset.size) === state.size)));
    $('[data-mobile-thumbs]').innerHTML = state.slots.slice(0, 3).map(id => `<span>${id ? watchArt(watches.get(id)) : '<i></i>'}</span>`).join('');
    $('[data-mobile-count]').textContent = count + ' of ' + state.size + ' chosen';
    $('[data-mobile-price]').textContent = price === null ? 'Price to be confirmed' : money(price) + ' USD · planned';
  }
  function render() {
    root.dataset.motion = motion ? 'on' : 'off';
    const motionButton = $('[data-action="motion"]');
    motionButton.textContent = motion ? 'Motion on' : 'Motion off';
    motionButton.setAttribute('aria-pressed', String(motion));
    renderCatalog();
    renderBox();
  }
  function commit(next, message, focusKey) {
    state = next;
    save();
    render();
    if (message) notify(message);
    restoreFocus(focusKey);
  }
  function openDialog(content, mode, opener) {
    if (!dialog.open) dialogOpener = opener || document.activeElement;
    dialogContent.innerHTML = content;
    prepareOverheadImages();
    if (!dialog.open) dialog.showModal();
    dialog.scrollTop = 0;
    const heading = dialogContent.querySelector('h2');
    if (heading) { heading.tabIndex = -1; heading.focus(); }
  }
  function closeDialog() { if (dialog.open) dialog.close(); }
  dialog.addEventListener('close', () => {
    document.body.classList.remove('studio-dialog-open');
    if (dialogOpener && dialogOpener.isConnected) dialogOpener.focus({ preventScroll: true });
  });
  dialog.addEventListener('click', event => {
    if (event.target === dialog) {
      const rect = dialog.getBoundingClientRect();
      if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) closeDialog();
    }
  });
  function title(kicker, heading) { return `<p class="studio-kicker">${kicker}</p><h2 id="studio-dialog-title">${heading}</h2>`; }
  function showDetails(id, opener) {
    const watch = watches.get(id);
    if (!watch) return;
    const selected = state.slots.includes(id);
    const functionality = watch.style === 'chronograph' ? 'Chronograph operation is not verified.' : watch.style === 'moonphase' ? 'A working moonphase is not verified.' : watch.style === 'skeleton' ? 'The movement and open-work construction are not verified.' : 'Movement and functions are not verified.';
    openDialog(`<div class="studio-detail-layout"><div class="studio-detail-art">${watchArt(watch)}<span>ORIGINAL CONCEPT ILLUSTRATION</span></div><div class="studio-detail-copy">${title(escape(watch.styleLabel) + ' / DESIGN PREVIEW', escape(watch.name))}<p class="studio-detail-intro">${escape(watch.description)}</p><dl class="studio-specs"><div><dt>Dial / finish</dt><dd>${escape(watch.dial)} / ${escape(watch.finish)}</dd></div><div><dt>Strap design</dt><dd>${escape(watch.strapLabel)}</dd></div><div><dt>Movement / functions</dt><dd>To be verified</dd></div><div><dt>Case / crystal / fit</dt><dd>To be verified</dd></div><div><dt>Water resistance</dt><dd>No rating confirmed</dd></div></dl><p class="studio-detail-note">${functionality} Final photography, materials, dimensions and specifications will replace this concept before launch.</p><button type="button" class="studio-primary" data-action="${selected ? 'review' : 'detail-add'}" data-id="${escape(id)}">${selected ? 'See it in my collection' : state.target !== null ? 'Replace selected watch' : model.count(state) === state.size ? 'Choose a watch to replace' : 'Add to my box'}<span aria-hidden="true">${selected ? '↗' : '+'}</span></button></div></div>`, 'details', opener);
    document.body.classList.add('studio-dialog-open');
  }
  function reviewRows() {
    return state.slots.map((id, index) => {
      if (!id) return `<li class="studio-review-row is-empty"><span class="studio-review-number">${String(index + 1).padStart(2, '0')}</span><div><strong>A little room for you.</strong><p>Choose the next watch for your collection.</p></div><button type="button" class="studio-text-button" data-action="replace" data-slot="${index}">Choose ↗</button></li>`;
      const watch = watches.get(id);
      return `<li class="studio-review-row"><span class="studio-review-number">${String(index + 1).padStart(2, '0')}</span><div class="studio-review-art">${watchArt(watch)}</div><div class="studio-review-watch"><strong>${escape(watch.name)}</strong><p>${escape(watch.styleLabel)} · ${escape(watch.dial)}</p><div class="studio-review-edit"><button type="button" data-action="replace" data-slot="${index}">Replace</button><button type="button" data-action="remove" data-slot="${index}" aria-label="Remove ${escape(watch.name)}">Remove</button></div></div><div class="studio-reorder"><button type="button" data-action="move" data-slot="${index}" data-to="${index - 1}" aria-label="Move ${escape(watch.name)} earlier" ${index === 0 ? 'disabled' : ''}>↑</button><button type="button" data-action="move" data-slot="${index}" data-to="${index + 1}" aria-label="Move ${escape(watch.name)} later" ${index === state.size - 1 ? 'disabled' : ''}>↓</button></div></li>`;
    }).join('');
  }
  function showReview(opener) {
    const full = model.count(state) === state.size;
    openDialog(`<div class="studio-review">${title('YOUR COLLECTION / ' + model.count(state) + ' OF ' + state.size + ' CHOSEN', full ? 'That looks like you.' : 'See it coming together.')}<p class="studio-review-intro">Every piece has its place. Replace, remove or rearrange until it feels right.</p><div class="studio-review-overhead">${boxMarkup()}</div><ol class="studio-review-list">${reviewRows()}</ol><div class="studio-review-total"><div><span>Planned collection price</span><strong class="${model.price(state) === null ? 'is-pending' : ''}">${money(model.price(state))}${model.price(state) === null ? '' : ' <small>USD</small>'}</strong></div><p>${state.size} ${state.size === 1 ? 'watch' : 'watches'} of your choice + presentation box.<br>Shipping and taxes to be confirmed before launch.</p></div><p class="studio-review-note">Design preview only. These are concept watches, not confirmed inventory. Orders and checkout are not available.</p><button type="button" class="studio-primary" data-action="${full ? 'keep' : 'continue'}">${full ? 'Keep this selection' : 'Continue choosing'}<span aria-hidden="true">↗</span></button><p class="studio-save-note">${storageAvailable ? 'Your selection is saved on this device. No account needed.' : 'Your selection is kept for this visit. Browser storage is unavailable.'}</p></div>`, 'review', opener);
    document.body.classList.add('studio-dialog-open');
  }
  function requestSize(size, opener) {
    if (!model.validSize(size) || size === state.size) return;
    const selected = state.slots.filter(Boolean);
    if (selected.length > size) {
      const removed = selected.slice(size).map(id => watches.get(id).name);
      openDialog(`<div class="studio-confirm">${title('CHANGE YOUR BOX', 'Make it a little smaller?')}<p>The first ${size} ${size === 1 ? 'watch stays' : 'watches stay'} in your collection. These will be removed:</p><ul>${removed.map(name => `<li>${escape(name)}</li>`).join('')}</ul><p>You can add them again later.</p><div class="studio-confirm-actions"><button type="button" class="studio-primary" data-action="confirm-size" data-size="${size}">Switch to ${size} ${size === 1 ? 'watch' : 'watches'}</button><button type="button" class="studio-text-button" data-action="close-dialog">Keep my current box</button></div></div>`, 'resize', opener);
      document.body.classList.add('studio-dialog-open');
    } else {
      commit(model.resize(state, size), 'Room for ' + size + (size === 1 ? ' watch.' : ' watches.'));
    }
  }
  function flyToBox(watch, rect, index) {
    if (!motion || !rect || !Element.prototype.animate) return;
    const mobile = window.matchMedia('(max-width: 960px)').matches;
    const destination = mobile ? $('[data-mobile-thumbs]') : $(`[data-box-tray] [data-slot="${index}"]`);
    if (!destination) return;
    const to = destination.getBoundingClientRect();
    if (to.top >= window.innerHeight || to.bottom <= 0) return;
    const ghost = document.createElement('div');
    ghost.className = 'studio-flight';
    ghost.setAttribute('aria-hidden', 'true');
    ghost.style.cssText = `left:${rect.left}px;top:${rect.top}px;width:${rect.width}px;height:${rect.height}px;`;
    ghost.innerHTML = watchArt(watch);
    document.body.appendChild(ghost);
    ghost.animate([{ transform: 'translate(0, 0) scale(.8)', opacity: .9 }, { transform: `translate(${to.left + to.width / 2 - rect.left - rect.width / 2}px, ${to.top + to.height / 2 - rect.top - rect.height / 2}px) scale(.2)`, opacity: .1 }], { duration: 520, easing: 'cubic-bezier(.2,.7,.2,1)' }).finished.then(() => ghost.remove(), () => ghost.remove());
  }
  function add(id, source, exactSlot) {
    const watch = watches.get(id);
    if (!watch) return;
    if (state.slots.includes(id)) { notify(watch.name + ' is already in your box.'); return; }
    if (exactSlot === undefined && state.target === null && model.count(state) === state.size) {
      openDialog(`<div class="studio-confirm">${title('A CHANGE OF MIND', 'Make room for ' + escape(watch.name) + '.')}<p>Your box is full. Choose the watch you would like to replace.</p><div class="studio-swap-options">${state.slots.map((selected, index) => `<button type="button" data-action="swap-with" data-id="${escape(id)}" data-slot="${index}"><span>${String(index + 1).padStart(2, '0')}</span>${escape(watches.get(selected).name)}<span aria-hidden="true">↔</span></button>`).join('')}</div><button type="button" class="studio-text-button" data-action="close-dialog">Keep my collection</button></div>`, 'swap', source);
      document.body.classList.add('studio-dialog-open');
      return;
    }
    const index = exactSlot === undefined ? (state.target === null ? state.slots.indexOf(null) : state.target) : exactSlot;
    const previous = state.slots[index];
    const visual = track.querySelector(`[data-carousel-slide][data-id="${id}"] .studio-carousel-visual`);
    const rect = visual && !dialog.open ? visual.getBoundingClientRect() : null;
    closeDialog();
    commit(model.put(state, id, index), watch.name + (previous ? ' replaced ' + watches.get(previous).name + '.' : ' added to your box.'), '[data-feature-add]');
    flyToBox(watch, rect, index);
  }
  function chooseSlot(index) {
    closeDialog();
    commit(model.target(state, index));
    $('#studio-catalog-title').scrollIntoView({ behavior: motion ? 'smooth' : 'auto', block: 'start' });
    $('#studio-catalog-title').focus({ preventScroll: true });
  }
  root.addEventListener('click', event => {
    const button = event.target.closest('button[data-action]');
    if (!button || !root.contains(button) || button.disabled) return;
    const id = button.dataset.id;
    const index = Number(button.dataset.slot);
    switch (button.dataset.action) {
      case 'filter': filter = button.dataset.style; renderCatalog(); break;
      case 'reset-filters':
        filter = 'all'; search = ''; strap = 'all';
        $('[data-studio-search]').value = ''; $('[data-studio-strap]').value = 'all';
        renderCatalog(); $('[data-studio-search]').focus(); break;
      case 'size': requestSize(Number(button.dataset.size), button); break;
      case 'confirm-size': closeDialog(); commit(model.resize(state, Number(button.dataset.size), true), 'Your box size has been updated.'); break;
      case 'focus-watch': centerWatch(id, true); break;
      case 'previous-watch': moveCarousel(-1); break;
      case 'next-watch': moveCarousel(1); break;
      case 'details': showDetails(id, button); break;
      case 'add': case 'detail-add': add(id, button); break;
      case 'swap-with': add(id, button, index); break;
      case 'review': showReview(button); break;
      case 'slot': if (state.slots[index]) showReview(button); else chooseSlot(index); break;
      case 'replace': chooseSlot(index); break;
      case 'cancel-replace': commit(model.target(state, null)); break;
      case 'remove':
        commit(model.remove(state, index), 'Watch removed. There is room for something else.');
        if (dialog.open) { showReview(dialogOpener); restoreFocus(`[data-dialog-content] [data-action="${index < state.size - 1 ? 'remove' : 'replace'}"]`); }
        break;
      case 'move':
        commit(model.move(state, index, Number(button.dataset.to)), 'Your collection order has been updated.');
        showReview(dialogOpener);
        restoreFocus(`[data-dialog-content] [data-action="move"][data-slot="${button.dataset.to}"][data-to="${index}"]`);
        break;
      case 'clear':
        openDialog(`<div class="studio-confirm">${title('A FRESH START', 'Clear your collection?')}<p>Your selected watches will be removed. Your ${state.size}-watch box size stays the same.</p><div class="studio-confirm-actions"><button type="button" class="studio-primary" data-action="confirm-clear">Clear my selection</button><button type="button" class="studio-text-button" data-action="close-dialog">Keep my collection</button></div></div>`, 'clear', button);
        document.body.classList.add('studio-dialog-open'); break;
      case 'confirm-clear': closeDialog(); commit(model.empty(state.size), 'A fresh start. Find your first watch.'); break;
      case 'keep': save(); closeDialog(); renderBox(); notify(storageAvailable ? 'Your collection is saved on this device.' : 'Your collection is kept for this visit.'); break;
      case 'continue': closeDialog(); $('#studio-catalog-title').scrollIntoView({ behavior: motion ? 'smooth' : 'auto', block: 'start' }); $('#studio-catalog-title').focus({ preventScroll: true }); break;
      case 'close-dialog': closeDialog(); break;
      case 'motion': motion = !motion; root.dataset.motion = motion ? 'on' : 'off'; button.textContent = motion ? 'Motion on' : 'Motion off'; button.setAttribute('aria-pressed', String(motion)); break;
    }
  });
  track.addEventListener('scroll', () => {
    cancelAnimationFrame(scrollFrame);
    scrollFrame = requestAnimationFrame(nearestWatch);
    clearTimeout(scrollTimer);
    scrollTimer = setTimeout(settleCarousel, 160);
  }, { passive: true });
  track.addEventListener('scrollend', settleCarousel);
  track.addEventListener('pointerdown', () => { carouselTarget = null; }, { passive: true });
  track.addEventListener('wheel', () => { carouselTarget = null; }, { passive: true });
  track.addEventListener('keydown', event => {
    if (event.altKey || event.ctrlKey || event.metaKey || !carouselWatches.length) return;
    const index = carouselWatches.findIndex(watch => watch.id === activeWatchId);
    const next = event.key === 'ArrowLeft' ? index - 1 : event.key === 'ArrowRight' ? index + 1 : event.key === 'Home' ? 0 : event.key === 'End' ? carouselWatches.length - 1 : -1;
    if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
    event.preventDefault();
    if (carouselWatches[next]) {
      centerWatch(carouselWatches[next].id, true);
      if (event.target !== track) track.querySelector(`[data-action="focus-watch"][data-id="${activeWatchId}"]`).focus({ preventScroll: true });
    }
  });
  let carouselWidth = 0;
  function resizeCarousel() {
    if (!track.clientWidth || track.clientWidth === carouselWidth) return;
    carouselWidth = track.clientWidth;
    cancelAnimationFrame(centerFrame);
    centerFrame = requestAnimationFrame(() => centerWatch(activeWatchId, false));
  }
  if (window.ResizeObserver) new ResizeObserver(resizeCarousel).observe(track);
  else window.addEventListener('resize', resizeCarousel);
  $('[data-studio-search]').addEventListener('input', event => { search = event.target.value.trim().toLowerCase(); renderCatalog(); });
  $('[data-studio-strap]').addEventListener('change', event => { strap = event.target.value; renderCatalog(); });
  window.matchMedia('(prefers-reduced-motion: reduce)').addEventListener('change', event => {
    if (event.matches) { motion = false; root.dataset.motion = 'off'; $('[data-action="motion"]').textContent = 'Motion off'; $('[data-action="motion"]').setAttribute('aria-pressed', 'false'); }
  });
  save();
  render();
  if (model.validSize(requestedSize) && requestedSize !== state.size) requestSize(requestedSize);
}());
