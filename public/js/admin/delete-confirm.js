/**
 * Admin single-row delete – intercepts .admin-delete-one clicks,
 * shows confirmation, then submits a DELETE form.
 */
(function () {
    'use strict';

    if (window.__adminDeleteBound) return;
    window.__adminDeleteBound = true;

    document.body.addEventListener('click', function (e) {
        var btn = e.target.closest('.admin-delete-one');
        if (!btn) return;
        e.preventDefault();

        var url = btn.getAttribute('data-delete-url');
        var msg = btn.getAttribute('data-delete-confirm') || 'Are you sure?';
        if (!url) return;
        if (!confirm(msg)) return;

        var form = document.createElement('form');
        form.method = 'POST';
        form.action = url;

        var csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        var meta = document.querySelector('meta[name="csrf-token"]');
        csrf.value = meta ? meta.getAttribute('content') : '';
        form.appendChild(csrf);

        var method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);

        document.body.appendChild(form);
        form.submit();
    });
})();
