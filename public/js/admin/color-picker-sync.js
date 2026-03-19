/**
 * Admin color picker sync – keeps input[type="color"] pickers
 * in sync with their paired text inputs.
 * Convention: picker id = "key_picker", text input id = "key".
 */
(function () {
    'use strict';

    function init() {
        document.querySelectorAll('input[type="color"][id$="_picker"]').forEach(function (picker) {
            var key = picker.id.replace('_picker', '');
            var textInput = document.getElementById(key);
            if (!textInput) return;

            picker.addEventListener('input', function () {
                textInput.value = this.value;
            });
            textInput.addEventListener('input', function () {
                var v = this.value.replace(/^#/, '');
                if (/^[a-fA-F0-9]{6}$/.test(v)) picker.value = '#' + v;
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
