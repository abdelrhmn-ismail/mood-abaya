/**
 * Admin locale tabs – switches between .locale-panel sections
 * using .locale-tab buttons with data-locale attributes.
 */
(function () {
    'use strict';

    function init() {
        var tabs = document.querySelectorAll('.locale-tab');
        if (!tabs.length) return;

        tabs.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var locale = this.getAttribute('data-locale');
                document.querySelectorAll('.locale-tab').forEach(function (b) {
                    b.classList.remove('bg-gray-200', 'text-gray-900');
                    b.classList.add('text-gray-600');
                });
                this.classList.add('bg-gray-200', 'text-gray-900');
                this.classList.remove('text-gray-600');
                document.querySelectorAll('.locale-panel').forEach(function (p) {
                    p.classList.toggle('hidden', p.getAttribute('data-locale') !== locale);
                });
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
