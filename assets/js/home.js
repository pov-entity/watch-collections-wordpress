/**
 * Progressive, non-transactional homepage package preview.
 * No WooCommerce cart, network requests or checkout behavior.
 */
(function () {
  'use strict';
  var container = document.querySelector('.wc-home');
  if (!container) return;

  var tiers = Array.prototype.slice.call(container.querySelectorAll('.wc-tier'));
  var slots = container.querySelector('#wc-case-slots');
  var caseFrame = container.querySelector('#wc-case');
  var price = container.querySelector('#wc-selection-price');
  var includes = container.querySelector('#wc-selection-includes');
  var caption = container.querySelector('#wc-slot-caption');
  if (!tiers.length || !slots || !caseFrame || !price || !includes || !caption) return;

  function renderBox(button) {
    var count = Number(button.getAttribute('data-count'));
    var amount = Number(button.getAttribute('data-price'));
    if ([1, 3, 5, 7].indexOf(count) === -1 || !Number.isFinite(amount)) return;
    tiers.forEach(function (item) {
      var active = item === button;
      item.classList.toggle('is-selected', active);
      item.setAttribute('aria-pressed', active ? 'true' : 'false');
    });

    slots.replaceChildren();
    for (var i = 1; i <= count; i++) {
      var slot = document.createElement('div');
      slot.className = 'wc-case__slot';
      var cushion = document.createElement('span');
      cushion.className = 'wc-case__cushion';
      cushion.setAttribute('aria-hidden', 'true');
      var number = document.createElement('span');
      number.className = 'wc-case__number';
      number.textContent = String(i).padStart(2, '0');
      slot.appendChild(cushion);
      slot.appendChild(number);
      slots.appendChild(slot);
    }

    slots.style.setProperty('--wc-box-cols', String(count === 1 ? 1 : count === 3 ? 3 : 4));
    caseFrame.setAttribute('data-count', String(count));
    caseFrame.setAttribute('aria-label', 'Preview of ' + count + ' empty watch compartment' + (count === 1 ? '' : 's'));
    price.textContent = '$' + amount.toLocaleString('en-US');
    includes.textContent = count + ' ' + (count === 1 ? 'watch' : 'watches') + ' of your choice + ' + count + '-slot presentation box';
    caption.textContent = String(count).padStart(2, '0') + ' EMPTY ' + (count === 1 ? 'COMPARTMENT' : 'COMPARTMENTS');
  }

  tiers.forEach(function (button) {
    button.addEventListener('click', function () { renderBox(button); });
  });
})();