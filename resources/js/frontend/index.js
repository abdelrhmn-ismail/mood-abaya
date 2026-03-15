/**
 * Frontend entry – initializes all frontend modules
 */
import Alpine from 'alpinejs';
import { initNavbar } from './navbar.js';
import { initNewsletter } from './newsletter.js';
import { initHeroSlider } from './hero-slider.js';
import { initCookieConsent } from './cookie-consent.js';
import { initCartWishlistAjax } from './cart-wishlist-ajax.js';

window.Alpine = Alpine;

function init() {
  Alpine.start();
  initHeroSlider();
  initNavbar();
  initNewsletter();
  initCookieConsent();
  initCartWishlistAjax();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
