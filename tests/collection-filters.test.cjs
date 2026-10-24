const { test } = require('node:test');
const assert = require('node:assert/strict');
const { facetValue, facetOptions, filterWatches } = require('../assets/js/collection-state.js');
const watches = require('../assets/data/studio-catalog.json');

test('the current concept catalog has truthful brand labels without invented manufacturers', () => {
  assert.deepEqual(facetOptions(watches, 'brand'), ['Unbranded concepts']);
  assert.equal(facetValue(watches[0], 'brand'), 'Unbranded concepts');
  assert.deepEqual(facetOptions(watches, 'dial'), ['Black', 'Green', 'Ice blue', 'Ivory', 'Navy', 'Silver']);
});

test('brand options are populated from catalog entries when verified brands become available', () => {
  const listed = [...watches, { id: 'sample-a', name: 'Verified sample', style: 'sport', strap: 'bracelet', dial: 'Burgundy', brand: 'Example brand' }];
  assert.deepEqual(facetOptions(listed, 'brand'), ['Example brand', 'Unbranded concepts']);
  assert.deepEqual(filterWatches(listed, { brand: 'Example brand' }).map(w => w.id), ['sample-a']);
});

test('style, brand, strap type, dial color and search combine by intersection', () => {
  assert.deepEqual(filterWatches(watches, {
    style: 'classic', brand: 'Unbranded concepts', strap: 'leather-look', dial: 'Ivory', search: 'slate'
  }).map(w => w.id), ['concept-05']);
  assert.deepEqual(filterWatches(watches, { strap: 'bracelet', dial: 'Ice blue' }).map(w => w.id), ['concept-06']);
  assert.deepEqual(filterWatches(watches, { brand: 'Unbranded concepts', dial: 'Navy', search: 'night' }).map(w => w.id), ['concept-04']);
});

test('conflicting filters return empty; clearing every criterion restores all watches', () => {
  assert.equal(filterWatches(watches, { dial: 'Green', strap: 'leather-look' }).length, 0);
  assert.equal(filterWatches(watches, { search: 'does-not-exist' }).length, 0);
  assert.deepEqual(filterWatches(watches, { style: 'all', brand: 'all', strap: 'all', dial: 'all', search: '' }), watches);
});

test('search includes manufacturer brand when present', () => {
  const listed = [{ id: 'verified-1', name: 'Simple', brand: 'Example brand', style: 'classic', dial: 'Black', strap: 'bracelet' }];
  assert.equal(filterWatches(listed, { search: 'example' }).length, 1);
  assert.equal(filterWatches(listed, { search: 'example', dial: 'Navy' }).length, 0);
});
