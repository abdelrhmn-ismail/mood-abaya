/**
 * Admin color picker sync – keeps input[type="color"] pickers in sync with
 * their paired text inputs and live preview swatches.
 *
 * Convention: picker id = "key_picker", text input id = "key", preview id = "key_preview".
 */
(function () {
    'use strict';

    function normalizeHex(v) {
        v = (v || '').trim().replace(/^#/, '');
        if (/^[a-fA-F0-9]{6}$/.test(v)) return '#' + v;
        return null;
    }

    function updatePreview(key, hex) {
        var preview = document.getElementById(key + '_preview');
        if (preview && hex) {
            preview.style.backgroundColor = hex;
        }
    }

    function setColor(key, hex) {
        var picker = document.getElementById(key + '_picker');
        var textInput = document.getElementById(key);
        if (picker) picker.value = hex;
        if (textInput) textInput.value = hex;
        updatePreview(key, hex);
    }

    function init() {
        document.querySelectorAll('input[type="color"][id$="_picker"]').forEach(function (picker) {
            var key = picker.id.replace('_picker', '');
            var textInput = document.getElementById(key);
            if (!textInput) return;

            picker.addEventListener('input', function () {
                textInput.value = this.value;
                updatePreview(key, this.value);
            });

            textInput.addEventListener('input', function () {
                var hex = normalizeHex(this.value);
                if (hex) {
                    picker.value = hex;
                    updatePreview(key, hex);
                }
            });
        });

        document.querySelectorAll('.reset-color-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var key = this.getAttribute('data-key');
                var def = this.getAttribute('data-default');
                if (key && def) setColor(key, def);
            });
        });

        var resetAll = document.getElementById('reset-all-colors');
        if (resetAll) {
            resetAll.addEventListener('click', function () {
                document.querySelectorAll('.color-card').forEach(function (card) {
                    var key = card.getAttribute('data-color-key');
                    var def = card.getAttribute('data-default');
                    if (key && def) setColor(key, def);
                });
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
