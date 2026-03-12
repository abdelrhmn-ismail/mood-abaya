/**
 * Newsletter form – optional submit handler
 * Form should have data-newsletter="form"
 */
const SELECTOR = '[data-newsletter="form"]';

function initNewsletter() {
  const form = document.querySelector(SELECTOR);
  if (!form) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const input = form.querySelector('input[type="email"]');
    const email = input?.value?.trim();
    if (!email) return;
    // Placeholder: send to backend or analytics
    console.info('Newsletter signup:', email);
    if (input) input.value = '';
    // Could show a toast or message here
  });
}

export { initNewsletter };
