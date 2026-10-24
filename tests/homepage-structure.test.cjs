'use strict';
const test = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const root = path.resolve(__dirname, '..');
const read = (name) => fs.readFileSync(path.join(root, name), 'utf8');
const page = read('front-page.php');
const video = read('assets/js/week-hero.js');
const assets = read('functions.php');
const css = read('assets/css/home-refinement.css');
const packages = read('inc/collection-studio.php');
const footer = read('footer.php');
const section = (name) => {
  const start = page.indexOf('<section class="' + name);
  assert.ok(start >= 0, 'Missing ' + name);
  const end = page.indexOf('</section>', start);
  assert.ok(end > start);
  return page.slice(start, end + 10);
};

test('homepage ordering preserves navy assembly before collection choices', () => {
  const names = ['week-hero', 'editorial-quality', 'editorial-packages', 'editorial-process', 'editorial-fulfillment', 'editorial-assurance', 'editorial-closing'];
  const positions = names.map(name => page.indexOf('<section class="' + name));
  assert.ok(positions.every(pos => pos >= 0));
  assert.ok(positions.every((pos, i) => !i || pos > positions[i - 1]));
  assert.ok(!page.includes('<section class="editorial-intro"'));
  assert.ok(!page.includes('<section class="editorial-feature-band"'));
});

test('the Details section contains exactly three distinct themes', () => {
  const details = section('editorial-quality');
  assert.equal((details.match(/<article>/g) || []).length, 3);
  for (const phrase of ['Movements — automatic & quartz', 'Sapphire & steel', 'Complexity with purpose']) {
    assert.ok(details.includes(phrase), phrase);
  }
  for (const keyword of ['chronograph', 'moonphase', 'Quartz', 'Automatic']) {
    assert.ok(details.includes(keyword), keyword);
  }
});

test('approved prototype prices are unchanged and six-watch price is pending', () => {
  assert.match(packages, /'count'\s*=>\s*1,\s*'price'\s*=>\s*160/);
  assert.match(packages, /'count'\s*=>\s*3,\s*'price'\s*=>\s*299/);
  assert.match(packages, /'count'\s*=>\s*6,\s*'price'\s*=>\s*null/);
  assert.ok(section('editorial-packages').includes('Preview this collection'));
});

test('hero explains 1, 3 and 6 watch collection and links into studio', () => {
  const hero = section('week-hero');
  assert.match(hero, /Choose 1, 3 or 6 watches/);
  assert.match(hero, /Build your/);
  assert.match(hero, /data-hero-video/);
  assert.match(hero, /data-hero-tab/);
  assert.match(hero, /data-hero-motion/);
});

test('video stills are loaded on demand, not seven eager images', () => {
  assert.ok(section('week-hero').includes("'data-src'"));
  assert.ok(video.includes('function loadFrame(index)'));
  assert.ok(video.includes('if (videoError || switching || !hasPlayed) loadFrame(index);'));
  assert.ok(section('editorial-quality').includes('preload="none"'));
});

test('mobile hierarchy and navigation accessibility are explicitly styled', () => {
  assert.ok(css.includes('.week-hero__moment{display:none}'));
  assert.ok(css.includes('menu-toggle{width:44px;height:44px'));
  assert.ok(css.includes('.week-hero__offer'));
  assert.ok(assets.includes("'watch-collections-home-refinement'"));
  assert.ok(assets.includes("'watch-collections-typography'"));
});

test('footer exposes before-you-buy information without broken policy links', () => {
  assert.ok(footer.includes('/#confidence'));
  assert.ok(footer.includes('get_page_by_path'));
  assert.ok(footer.includes('get_privacy_policy_url'));
});
