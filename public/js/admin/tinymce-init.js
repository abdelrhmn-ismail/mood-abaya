/**
 * Admin TinyMCE initialization – auto-inits any .rich-editor textarea.
 * The TinyMCE script itself must be loaded before this runs.
 * data-tinymce-height on the textarea overrides the default height.
 */
(function () {
    'use strict';

    function init() {
        if (typeof tinymce === 'undefined') return;
        var editors = document.querySelectorAll('.rich-editor');
        if (!editors.length) return;

        tinymce.init({
            selector: '.rich-editor',
            height: 220,
            menubar: false,
            plugins: 'lists link code',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link | removeformat | code',
            content_style: 'body { font-family: inherit; font-size: 14px; }',
            directionality: document.documentElement.dir || 'ltr',
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
