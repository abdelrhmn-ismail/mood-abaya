/**
 * Frontend entry – initializes all frontend modules
 */
import { initNavbar } from './navbar.js';
import { initNewsletter } from './newsletter.js';

function init() {
  initNavbar();
  initNewsletter();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
