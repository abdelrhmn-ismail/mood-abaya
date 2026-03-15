/**
 * Cookie consent bar: on Accept, set cookie and hide bar.
 */
export function initCookieConsent() {
  const bar = document.getElementById('cookie-consent-bar');
  const acceptBtn = document.getElementById('cookie-consent-accept');
  if (!bar || !acceptBtn) return;

  acceptBtn.addEventListener('click', () => {
    // 1 year
    document.cookie = 'cookie_consent=1; path=/; max-age=31536000; SameSite=Lax';
    bar.style.display = 'none';
  });
}
