/**
 * Navbar module – mobile menu toggle (single Material icon via ligature: menu ↔ close)
 */
const ATTR = 'data-navbar';
const SELECTORS = {
  navbar: `[id="main-navbar"]`,
  toggle: `[${ATTR}="toggle"]`,
  mobileMenu: `[${ATTR}="mobile-menu"]`,
  toggleIcon: `[${ATTR}="toggle-icon"]`,
};

function initNavbar() {
  const navbar = document.querySelector(SELECTORS.navbar);
  if (!navbar) return;

  const toggleBtn = navbar.querySelector(SELECTORS.toggle);
  const mobileMenu = navbar.querySelector(SELECTORS.mobileMenu);
  const toggleIcon = navbar.querySelector(SELECTORS.toggleIcon);

  if (!toggleBtn || !mobileMenu) return;

  const labelOpen = toggleBtn.getAttribute('data-label-open') || 'Toggle menu';
  const labelClose = toggleBtn.getAttribute('data-label-close') || 'Close menu';

  function setIcon(isOpen) {
    if (!toggleIcon) return;
    toggleIcon.textContent = isOpen ? 'close' : 'menu';
  }

  function open() {
    mobileMenu.classList.remove('hidden');
    mobileMenu.classList.add('flex');
    setIcon(true);
    toggleBtn.setAttribute('aria-expanded', 'true');
    toggleBtn.setAttribute('aria-label', labelClose);
  }

  function close() {
    mobileMenu.classList.add('hidden');
    mobileMenu.classList.remove('flex');
    setIcon(false);
    toggleBtn.setAttribute('aria-expanded', 'false');
    toggleBtn.setAttribute('aria-label', labelOpen);
  }

  function toggle() {
    const isOpen = !mobileMenu.classList.contains('hidden');
    if (isOpen) close();
    else open();
  }

  toggleBtn.addEventListener('click', toggle);

  window.addEventListener('resize', () => {
    if (window.matchMedia('(min-width: 768px)').matches) close();
  });

  mobileMenu.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', close);
  });
}

export { initNavbar };
