/**
 * Navbar – mobile menu toggle
 */
(function () {
    'use strict';

    var SELECTORS = {
        navbar: '#main-navbar',
        toggle: '[data-navbar="toggle"]',
        mobileMenu: '[data-navbar="mobile-menu"]',
        iconOpen: '[data-navbar="icon-open"]',
        iconClose: '[data-navbar="icon-close"]',
    };

    function initNavbar() {
        var navbar = document.querySelector(SELECTORS.navbar);
        if (!navbar) return;

        var toggleBtn = navbar.querySelector(SELECTORS.toggle);
        var mobileMenu = navbar.querySelector(SELECTORS.mobileMenu);
        var iconOpen = navbar.querySelector(SELECTORS.iconOpen);
        var iconClose = navbar.querySelector(SELECTORS.iconClose);

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
