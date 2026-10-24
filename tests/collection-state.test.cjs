const { test } = require('node:test');
const assert = require('node:assert/strict');
const { createModel } = require('../assets/js/collection-state.js');
const watches = require('../assets/data/studio-catalog.json');
const model = createModel(watches, [{ count: 1, price: 179 }, { count: 3, price: 333 }, { count: 6, price: 579 }]);
const ids = watches.map(watch => watch.id);

test('only 1, 3 and 6-watch boxes are accepted', () => {
  for (const size of [1, 3, 6]) assert.equal(model.empty(size).slots.length, size);
  for (const size of [0, 2, 5, 7, '6', -1, NaN]) assert.equal(model.validSize(size), false);
});
test('adding a watch fills the next opening without mutating earlier state', () => {
  const before = model.empty(3);
  const after = model.put(before, ids[0]);
  assert.deepEqual(before.slots, [null, null, null]);
  assert.deepEqual(after.slots, [ids[0], null, null]);
  assert.equal(model.put(after, ids[0]), after);
  assert.equal(model.put(after, 'unknown'), after);
});
test('full collections never silently replace a watch', () => {
  const full = ids.slice(0, 3).reduce((state, id) => model.put(state, id), model.empty(3));
  assert.equal(model.put(full, ids[3]), full);
  assert.deepEqual(model.put(full, ids[3], 1).slots, [ids[0], ids[3], ids[2]]);
});
test('targeted replacement changes exactly one compartment', () => {
  const initial = model.put(model.put(model.empty(3), ids[0]), ids[1]);
  const result = model.put(model.target(initial, 0), ids[2]);
  assert.deepEqual(result.slots, [ids[2], ids[1], null]);
  assert.equal(result.target, null);
});
test('reducing a filled box requires explicit discard and preserves order', () => {
  const full = ids.slice(0, 6).reduce((state, id) => model.put(state, id), model.empty(6));
  assert.equal(model.resize(full, 3), full);
  assert.deepEqual(model.resize(full, 3, true).slots, ids.slice(0, 3));
});
test('shrinking a sparse box retains every selection that fits', () => {
  const sparse = model.put(model.put(model.empty(6), ids[0], 4), ids[1], 5);
  assert.deepEqual(model.resize(sparse, 3).slots, [ids[0], ids[1], null]);
  assert.deepEqual(model.resize(model.resize(sparse, 3), 6).slots, [ids[0], ids[1], null, null, null, null]);
});
test('removal opens a slot and moving swaps complete compartment contents', () => {
  const filled = model.put(model.put(model.empty(3), ids[0]), ids[1]);
  assert.deepEqual(model.move(filled, 0, 1).slots, [ids[1], ids[0], null]);
  assert.deepEqual(model.remove(filled, 0).slots, [null, ids[1], null]);
  assert.equal(model.move(filled, 0, 8), filled);
});
test('restoring storage rejects corrupt, obsolete and duplicate selections', () => {
  assert.equal(model.hydrate('{bad', 6).size, 6);
  assert.equal(model.hydrate({ version: 1, size: 7, slots: ids }, 3).size, 3);
  const restored = model.hydrate({ version: 1, size: 3, slots: [ids[0], ids[0], 'deleted'], target: 2, price: 1 }, 3);
  assert.deepEqual(restored.slots, [ids[0], null, null]);
  assert.equal(restored.target, null);
  assert.equal(model.price(restored), 333);
});
test('approved collection prices apply to all three box sizes', () => {
  assert.equal(model.price(model.empty(1)), 179);
  assert.equal(model.price(model.empty(3)), 333);
  assert.equal(model.price(model.empty(6)), 579);
});
test('saved selections exclude temporary replacement state and prices', () => {
  const saved = JSON.parse(model.serialize(model.target(model.put(model.empty(3), ids[0]), 0)));
  assert.deepEqual(saved, { version: 1, size: 3, slots: [ids[0], null, null] });
});
