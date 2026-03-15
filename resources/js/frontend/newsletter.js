/**
 * Newsletter form – submit to backend, show success/error message
 * Form should have data-newsletter="form"; message area data-newsletter="message"
 */
const SELECTOR = '[data-newsletter="form"]';
const MESSAGE_SELECTOR = '[data-newsletter="message"]';

function initNewsletter() {
  const form = document.querySelector(SELECTOR);
  if (!form) return;

  const input = form.querySelector('input[type="email"]');
  const messageEl = document.querySelector(MESSAGE_SELECTOR);

  function setMessage(text, isError = false) {
    if (!messageEl) return;
    messageEl.textContent = text || '';
    messageEl.classList.toggle('text-red-200', isError);
    messageEl.classList.toggle('text-white/90', !isError);
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const email = input?.value?.trim();
    if (!email) {
      setMessage('Please enter your email.', true);
      return;
    }

    setMessage('');
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn?.textContent;
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = '...';
    }

    try {
      const body = new FormData(form);
      const res = await fetch(form.action, {
        method: 'POST',
        body: body,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          Accept: 'application/json',
          ...(form.querySelector('[name="_token"]') ? { 'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value } : {}),
        },
      });
      const data = await res.json().catch(() => ({}));

      if (res.ok && data.success) {
        setMessage(data.message || 'Thank you! You are subscribed.');
        if (input) input.value = '';
      } else {
        setMessage(data.message || data.errors?.email?.[0] || 'Something went wrong. Please try again.', true);
      }
    } catch (err) {
      setMessage('Something went wrong. Please try again.', true);
    } finally {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText || 'Subscribe';
      }
    }
  });
}

export { initNewsletter };
