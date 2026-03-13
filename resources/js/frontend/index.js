/**
 * Frontend entry – initializes all frontend modules
 */
import { initNavbar } from './navbar.js';
import { initNewsletter } from './newsletter.js';
import { initHeroSlider } from './hero-slider.js';

function init() {
  initHeroSlider();
  initNavbar();
  initNewsletter();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
