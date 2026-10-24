/* Browser-local prototype state. Never an authority for price, stock or orders. */
(function (root, factory) {
  'use strict';
  if (typeof module === 'object' && module.exports) module.exports = factory();
  else root.DialByDayCollection = factory();
}(typeof window !== 'undefined' ? window : globalThis, function () {
  'use strict';
  function createModel(watches, packages) {
    const ids = new Set(watches.map(watch => watch.id));
    const sizes = packages.map(item => item.count);
    const validSize = size => Number.isInteger(size) && sizes.includes(size);
    const empty = size => ({ version: 1, size: validSize(size) ? size : 3, slots: Array(validSize(size) ? size : 3).fill(null), target: null });
    const count = state => state.slots.filter(Boolean).length;
    const validIndex = (state, index) => Number.isInteger(index) && index >= 0 && index < state.size;
    function hydrate(raw, defaultSize) {
      let saved;
      try { saved = typeof raw === 'string' ? JSON.parse(raw) : raw; } catch (_) { return empty(defaultSize); }
      if (!saved || saved.version !== 1 || !validSize(saved.size) || !Array.isArray(saved.slots)) return empty(defaultSize);
      const state = empty(saved.size);
      const used = new Set();
      state.slots = state.slots.map((_, i) => {
        const id = saved.slots[i];
        if (typeof id !== 'string' || !ids.has(id) || used.has(id)) return null;
        used.add(id);
        return id;
      });
      return state;
    }
    function resize(state, size, allowDiscard) {
      if (!validSize(size)) return state;
      const selected = state.slots.filter(Boolean);
      if (selected.length > size && !allowDiscard) return state;
      const slots = size >= state.size ? state.slots.concat(Array(size - state.size).fill(null)) : selected.slice(0, size).concat(Array(Math.max(0, size - selected.length)).fill(null));
      return { ...state, size, slots, target: null };
    }
    function put(state, id, index) {
      if (!ids.has(id) || state.slots.includes(id)) return state;
      const destination = index === undefined ? (state.target === null ? state.slots.indexOf(null) : state.target) : index;
      if (!validIndex(state, destination)) return state;
      const slots = state.slots.slice();
      slots[destination] = id;
      return { ...state, slots, target: null };
    }
    function remove(state, index) {
      if (!validIndex(state, index)) return state;
      const slots = state.slots.slice();
      slots[index] = null;
      return { ...state, slots, target: null };
    }
    function move(state, from, to) {
      if (!validIndex(state, from) || !validIndex(state, to)) return state;
      const slots = state.slots.slice();
      [slots[from], slots[to]] = [slots[to], slots[from]];
      return { ...state, slots, target: null };
    }
    function target(state, index) {
      return { ...state, target: validIndex(state, index) ? index : null };
    }
    function price(state) {
      const item = packages.find(item => item.count === state.size);
      return item && typeof item.price === 'number' && Number.isFinite(item.price) ? item.price : null;
    }
    const serialize = state => JSON.stringify({ version: 1, size: state.size, slots: state.slots });
    return { empty, hydrate, resize, put, remove, move, target, count, price, serialize, validSize };
  }
  // Filters operate only on the public concept catalog; they never change box contents.
  // Missing brand is explicitly unbranded rather than inventing a manufacturer.
  function facetValue(watch, facet) {
    if (facet === 'brand') return String(watch.brand || '').trim() || 'Unbranded concepts';
    if (facet === 'dial') return String(watch.dial || '').trim();
    if (facet === 'strap') return String(watch.strap || '').trim();
    return '';
  }
  function facetOptions(watches, facet) {
    if (!['brand', 'dial'].includes(facet)) return [];
    return Array.from(new Set(watches.map(watch => facetValue(watch, facet)).filter(Boolean)))
      .sort((a, b) => a.localeCompare(b, undefined, { sensitivity: 'base' }));
  }
  function filterWatches(watches, selections = {}) {
    const search = String(selections.search || '').trim().toLowerCase();
    const matches = (actual, wanted) => !wanted || wanted === 'all' || String(actual).toLowerCase() === String(wanted).toLowerCase();
    return watches.filter(watch => {
      if (!matches(watch.style, selections.style) ||
          !matches(facetValue(watch, 'brand'), selections.brand) ||
          !matches(facetValue(watch, 'strap'), selections.strap) ||
          !matches(facetValue(watch, 'dial'), selections.dial)) return false;
      if (!search) return true;
      return [watch.name, watch.styleLabel, facetValue(watch, 'brand'), watch.dial, watch.strapLabel, watch.finish]
        .some(value => String(value || '').toLowerCase().includes(search));
    });
  }
  return { createModel, facetValue, facetOptions, filterWatches };
}));
