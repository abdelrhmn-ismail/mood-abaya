/**
 * Admin settings tabs – switches between .settings-panel sections
 * using .settings-tab buttons with data-tab attributes.
 */
(function () {
    'use strict';

    function init() {
        var tabs = document.querySelectorAll('.settings-tab');
        var panels = document.querySelectorAll('.settings-panel');
        if (!tabs.length) return;

        tabs.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var tab = this.getAttribute('data-tab');
                tabs.forEach(function (b) {
                    b.classList.remove('border-brand-teal', 'text-brand-teal');
                    b.classList.add('border-transparent', 'text-gray-500');
                });
                this.classList.add('border-brand-teal', 'text-brand-teal');
                this.classList.remove('border-transparent', 'text-gray-500');
                panels.forEach(function (p) {
                    p.classList.add('hidden');
                    if (p.id === 'tab-' + tab) p.classList.remove('hidden');
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
