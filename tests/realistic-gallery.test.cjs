const { test } = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const { facetOptions, filterWatches, createModel } = require('../assets/js/collection-state.js');
const watches = require('../assets/data/studio-catalog.json');
const read = filename => fs.readFileSync(path.join(__dirname, '..', filename), 'utf8');
const studio = read('assets/js/collection-studio.js');
const page = read('page-collection-studio.php');
const css = read('assets/css/collection-studio.css');

test('only catalog-backed case finish options are displayed', () => {
  assert.deepEqual(facetOptions(watches, 'finish'), ['Black tone', 'Gold tone', 'Silver tone']);
  assert.match(page, /data-studio-finish-choices/);
  assert.match(studio, /facetOptions\(config\.watches, 'finish'\)/);
  assert.match(studio, /value === 'all' \? 'All finishes'/);
  assert.doesNotMatch(studio, /Yellow gold|Two-tone|Rose gold/i);
});
test('all four facets plus watch type and search intersect', () => {
  const one = filterWatches(watches, {
    style: 'chronograph', brand: 'Unbranded concepts', strap: 'leather-look',
    dial: 'Black', finish: 'Gold tone', search: 'after hours'
  });
  assert.deepEqual(one.map(w => w.id), ['concept-02']);
  const noMatch = filterWatches(watches, { style: 'sport', finish: 'Gold tone', dial: 'Black' });
  assert.equal(noMatch.length, 0);
  assert.deepEqual(filterWatches(watches, { style: 'all', brand: 'all', strap: 'all', dial: 'all', finish: 'all', search: '' }), watches);
});
test('visual groups show full-watch artwork and provide image slots for verified photos', () => {
  assert.match(studio, /watchPreview\(watch\)/);
  assert.match(studio, /watch\.visuals\[kind\]/);
  assert.match(studio, /studio-watch-photo/);
  assert.match(studio, /previewTrio\(overview\)/);
  for (const facet of ['brand', 'finish', 'strap', 'dial']) {
    assert.match(page, new RegExp('data-studio-' + facet + '-choices'));
  }
  assert.match(css, /studio-finish-watch/);
  assert.match(css, /studio-strap-watch/);
});
test('filter choices report scoped matches and preserve accessible toggle state', () => {
  assert.match(studio, /data-facet-count/);
  assert.match(studio, /aria-pressed/);
  assert.match(studio, /button\.setAttribute\('aria-pressed', String\(isActive\)\)/);
  assert.match(studio, /style: value/);
  assert.match(studio, /finish = 'all'/);
  assert.match(css, /prefers-reduced-motion:reduce/);
});
test('pricing and saved box selection remain independent of filters', () => {
  const model = createModel(watches, [
    { count: 1, price: 179 }, { count: 3, price: 333 }, { count: 6, price: 579 }
  ]);
  const selected = model.put(model.empty(3), watches[0].id);
  assert.equal(model.price(selected), 333);
  const filtered = filterWatches(watches, { finish: 'Gold tone' });
  assert.equal(filtered.some(watch => watch.id === watches[0].id), false);
  assert.deepEqual(selected.slots, [watches[0].id, null, null]);
  assert.equal(model.price(model.empty(1)), 179);
  assert.equal(model.price(model.empty(6)), 579);
});
