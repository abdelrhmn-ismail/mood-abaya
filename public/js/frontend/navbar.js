/**
 * Navbar – mobile menu toggle (single Material icon: menu ↔ close via ligature text)
 */
(function () {
    'use strict';

    var SELECTORS = {
        navbar: '#main-navbar',
        toggle: '[data-navbar="toggle"]',
        mobileMenu: '[data-navbar="mobile-menu"]',
        toggleIcon: '[data-navbar="toggle-icon"]',
    };

    function initNavbar() {
        var navbar = document.querySelector(SELECTORS.navbar);
        if (!navbar) return;

        var toggleBtn = navbar.querySelector(SELECTORS.toggle);
        var mobileMenu = navbar.querySelector(SELECTORS.mobileMenu);
        var toggleIcon = navbar.querySelector(SELECTORS.toggleIcon);

        if (!toggleBtn || !mobileMenu) return;

        var labelOpen = toggleBtn.getAttribute('data-label-open') || 'Toggle menu';
        var labelClose = toggleBtn.getAttribute('data-label-close') || 'Close menu';

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
            var isOpen = !mobileMenu.classList.contains('hidden');
            if (isOpen) close();
            else open();
        }

        toggleBtn.addEventListener('click', toggle);

        window.addEventListener('resize', function () {
            if (window.matchMedia('(min-width: 768px)').matches) close();
        });

        mobileMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', close);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNavbar);
    } else {
        initNavbar();
    }
})();
