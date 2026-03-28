/**
 * Admin sidebar — mobile: one toggle (menu ↔ close), overlay + nav links close.
 */
(function () {
    'use strict';

    function init() {
        var sidebar = document.getElementById('admin-sidebar');
        var overlay = document.getElementById('sidebar-overlay');
        var toggle = document.getElementById('sidebar-toggle');
        var toggleIcon = toggle ? toggle.querySelector('[data-sidebar-toggle-icon]') : null;

        if (!sidebar || !toggle) return;

        var labelOpen = toggle.getAttribute('data-label-open') || 'Open menu';
        var labelClose = toggle.getAttribute('data-label-close') || 'Close menu';

        function isMobile() {
            return window.matchMedia('(max-width: 767px)').matches;
        }

        function isOpen() {
            return sidebar.classList.contains('is-open');
        }

        function syncToggleIcons(open) {
            if (toggleIcon) {
                toggleIcon.textContent = open ? 'close' : 'menu';
            }
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.setAttribute('aria-label', open ? labelClose : labelOpen);
        }

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('is-open');
            if (overlay) overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            syncToggleIcons(true);
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('is-open');
            if (overlay) overlay.classList.add('hidden');
            document.body.style.overflow = '';
            syncToggleIcons(false);
        }

        function toggleSidebar() {
            if (!isMobile()) return;
            if (isOpen()) closeSidebar();
            else openSidebar();
        }

        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            toggleSidebar();
        });

        if (overlay) overlay.addEventListener('click', closeSidebar);

        document.querySelectorAll('#admin-sidebar nav a').forEach(function (a) {
            a.addEventListener('click', function () {
                if (isMobile()) closeSidebar();
            });
        });

        window.addEventListener('resize', function () {
            if (!isMobile()) {
                sidebar.classList.remove('is-open');
                if (overlay) overlay.classList.add('hidden');
                document.body.style.overflow = '';
                syncToggleIcons(false);
            } else if (!isOpen()) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
