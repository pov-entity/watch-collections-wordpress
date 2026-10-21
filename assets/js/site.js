(function () {
  'use strict';
  var toggle = document.querySelector('.menu-toggle');
  var nav = document.querySelector('#site-navigation');
  if (!toggle || !nav) return;
  function setOpen(open) {
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    nav.classList.toggle('is-open', open);
  }
  toggle.addEventListener('click', function () {
    setOpen(toggle.getAttribute('aria-expanded') !== 'true');
  });
  nav.addEventListener('click', function (event) {
    if (event.target.closest('a')) setOpen(false);
  });
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') setOpen(false);
  });
  window.addEventListener('resize', function () {
    if (window.innerWidth > 650) setOpen(false);
  });
})();