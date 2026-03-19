/**
 * Newsletter form – AJAX submit with feedback messages
 */
(function () {
    'use strict';

    function initNewsletter() {
        var form = document.querySelector('[data-newsletter="form"]');
        if (!form) return;

        var input = form.querySelector('input[type="email"]');
        var messageEl = document.querySelector('[data-newsletter="message"]');

        function setMessage(text, isError) {
            if (!messageEl) return;
            messageEl.textContent = text || '';
            messageEl.classList.toggle('text-red-200', !!isError);
            messageEl.classList.toggle('text-white/90', !isError);
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var email = input && input.value ? input.value.trim() : '';
            if (!email) {
                setMessage('Please enter your email.', true);
                return;
            }

            setMessage('');
            var submitBtn = form.querySelector('button[type="submit"]');
            var originalText = submitBtn ? submitBtn.textContent : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = '...';
            }

            var body = new FormData(form);
            var tokenInput = form.querySelector('[name="_token"]');
            var headers = {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            };
            if (tokenInput) headers['X-CSRF-TOKEN'] = tokenInput.value;

            fetch(form.action, { method: 'POST', body: body, headers: headers })
                .then(function (res) {
                    return res.json().then(function (data) { return { ok: res.ok, data: data }; }).catch(function () { return { ok: res.ok, data: {} }; });
                })
                .then(function (result) {
                    if (result.ok && result.data.success) {
                        setMessage(result.data.message || 'Thank you! You are subscribed.');
                        if (input) input.value = '';
                    } else {
                        setMessage(result.data.message || (result.data.errors && result.data.errors.email && result.data.errors.email[0]) || 'Something went wrong. Please try again.', true);
                    }
                })
                .catch(function () {
                    setMessage('Something went wrong. Please try again.', true);
                })
                .finally(function () {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText || 'Subscribe';
                    }
                });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNewsletter);
    } else {
        initNewsletter();
    }
})();
