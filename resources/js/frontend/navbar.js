/**
 * Navbar module – mobile menu toggle
 * Uses data-navbar attributes on the navbar element.
 */
const ATTR = 'data-navbar';
const SELECTORS = {
  navbar: `[id="main-navbar"]`,
  toggle: `[${ATTR}="toggle"]`,
  mobileMenu: `[${ATTR}="mobile-menu"]`,
  iconOpen: `[${ATTR}="icon-open"]`,
  iconClose: `[${ATTR}="icon-close"]`,
};

function initNavbar() {
  const navbar = document.querySelector(SELECTORS.navbar);
  if (!navbar) return;

  const toggleBtn = navbar.querySelector(SELECTORS.toggle);
  const mobileMenu = navbar.querySelector(SELECTORS.mobileMenu);
  const iconOpen = navbar.querySelector(SELECTORS.iconOpen);
  const iconClose = navbar.querySelector(SELECTORS.iconClose);

  if (!toggleBtn || !mobileMenu) return;

  function open() {
    mobileMenu.classList.remove('hidden');
    mobileMenu.classList.add('flex');
    if (iconOpen) iconOpen.classList.add('hidden');
    if (iconClose) iconClose.classList.remove('hidden');
  }

  function close() {
    mobileMenu.classList.add('hidden');
    mobileMenu.classList.remove('flex');
    if (iconOpen) iconOpen.classList.remove('hidden');
    if (iconClose) iconClose.classList.add('hidden');
  }

  function toggle() {
    const isOpen = !mobileMenu.classList.contains('hidden');
    if (isOpen) close();
    else open();
  }

  toggleBtn.addEventListener('click', toggle);

  // Close on resize to desktop
  window.addEventListener('resize', () => {
    if (window.matchMedia('(min-width: 768px)').matches) close();
  });

  // Close when clicking a link (for in-page anchors)
  mobileMenu.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', close);
  });
}

export { initNavbar };
