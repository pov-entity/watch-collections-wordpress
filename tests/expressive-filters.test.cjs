const { test } = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const { filterWatches, facetOptions } = require('../assets/js/collection-state.js');
const watches = require('../assets/data/studio-catalog.json');
const read = name => fs.readFileSync(path.join(__dirname, '..', name), 'utf8');
const page = read('page-collection-studio.php');
const studio = read('assets/js/collection-studio.js');
const css = read('assets/css/collection-studio.css');

test('visual facets replace the old native dropdowns and remain accessible', () => {
  for (const facet of ['brand', 'strap', 'dial']) {
    assert.match(page, new RegExp('data-studio-' + facet + '-choices'));
    assert.doesNotMatch(page, new RegExp('<select[^>]*data-studio-' + facet));
  }
  assert.match(page, /aria-label="<\?php esc_attr_e\( 'Choose a dial color'/);
  assert.match(studio, /aria-pressed="false"/);
  assert.match(studio, /button\.setAttribute\('aria-pressed', String\(isActive\)\)/);
  assert.match(studio, /data-facet-count/);
});

test('dial colors are drawn using real prototype watch art, not named swatches only', () => {
  assert.match(studio, /studio-dial-portrait/);
  assert.match(studio, /watchPreview\(sample, 'dial'\)/);
  assert.match(studio, /studio-dial-trio/);
  assert.match(studio, /watchPreview\(watch, kind/);
  assert.equal(facetOptions(watches, 'dial').length, 6);
});

test('manufacturer choice has no invented brands', () => {
  assert.deepEqual(facetOptions(watches, 'brand'), ['Unbranded concepts']);
  assert.match(studio, /Concept designs/);
});

test('strap previews are visually differentiated', () => {
  for (const type of ['bracelet', 'leather-look', 'sport']) {
    assert.match(studio, /studio-strap-watch/);
    assert.match(studio, /groupedWatches\('strap'\)/);
    assert.ok(watches.some(watch => watch.strap === type));
  }
});

test('facet counts respect every other selected property and search', () => {
  const settings = { style: 'classic', brand: 'all', strap: 'all', dial: 'all', search: 'slate' };
  assert.equal(filterWatches(watches, { ...settings, strap: 'leather-look' }).length, 1);
  assert.equal(filterWatches(watches, { ...settings, strap: 'sport' }).length, 0);
  assert.equal(filterWatches(watches, { ...settings, dial: 'Ivory' }).length, 1);
  assert.equal(filterWatches(watches, { ...settings, dial: 'Black' }).length, 0);
});

test('box collection state, pricing and mobile motion accessibility stay intact', () => {
  assert.match(studio, /model\.put\(state, id, index\)/);
  assert.match(studio, /\[data-action="reset-filters"\]/);
  assert.match(css, /prefers-reduced-motion:reduce/);
  assert.match(studio, /studio-style-count/);
  assert.match(css, /@media\(max-width:700px\)/);
  assert.deepEqual(watches.map(watch => watch.id).length, 12);
});
