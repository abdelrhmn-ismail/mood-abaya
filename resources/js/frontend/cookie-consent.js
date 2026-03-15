const COOKIE_CONSENT_KEY = 'cookie_consent_accepted';
const COOKIE_NAME = 'cookie_consent';
const COOKIE_MAX_AGE = 31536000; // 1 year in seconds

function setConsentCookie() {
  document.cookie = `${COOKIE_NAME}=1; path=/; max-age=${COOKIE_MAX_AGE}; SameSite=Lax`;
}

/**
 * Cookie consent bar: persist acceptance in localStorage + cookie so we don't ask the client again.
 * On load, if user already accepted (localStorage or cookie), hide bar. On Accept, store in both.
 */
export function initCookieConsent() {
  const bar = document.getElementById('cookie-consent-bar');
  const acceptBtn = document.getElementById('cookie-consent-accept');
  if (!bar) return;

  const acceptedInStorage = typeof localStorage !== 'undefined' && localStorage.getItem(COOKIE_CONSENT_KEY) === '1';
  const acceptedInCookie = document.cookie.includes(`${COOKIE_NAME}=1`);

  if (acceptedInStorage || acceptedInCookie) {
    bar.style.display = 'none';
    if (!acceptedInCookie) setConsentCookie();
    if (!acceptedInStorage && typeof localStorage !== 'undefined') localStorage.setItem(COOKIE_CONSENT_KEY, '1');
    return;
  }

  if (!acceptBtn) return;

  acceptBtn.addEventListener('click', () => {
    setConsentCookie();
    if (typeof localStorage !== 'undefined') localStorage.setItem(COOKIE_CONSENT_KEY, '1');
    bar.style.display = 'none';
  });
}
