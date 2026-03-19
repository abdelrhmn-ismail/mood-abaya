/**
 * Cookie consent bar – persist acceptance in localStorage + cookie
 */
(function () {
    'use strict';

    var COOKIE_CONSENT_KEY = 'cookie_consent_accepted';
    var COOKIE_NAME = 'cookie_consent';
    var COOKIE_MAX_AGE = 31536000;

    function setConsentCookie() {
        document.cookie = COOKIE_NAME + '=1; path=/; max-age=' + COOKIE_MAX_AGE + '; SameSite=Lax';
    }

    function init() {
        var bar = document.getElementById('cookie-consent-bar');
        var acceptBtn = document.getElementById('cookie-consent-accept');
        if (!bar) return;

        var acceptedInStorage = typeof localStorage !== 'undefined' && localStorage.getItem(COOKIE_CONSENT_KEY) === '1';
        var acceptedInCookie = document.cookie.indexOf(COOKIE_NAME + '=1') !== -1;

        if (acceptedInStorage || acceptedInCookie) {
            bar.style.display = 'none';
            if (!acceptedInCookie) setConsentCookie();
            if (!acceptedInStorage && typeof localStorage !== 'undefined') localStorage.setItem(COOKIE_CONSENT_KEY, '1');
            return;
        }

        if (!acceptBtn) return;

        acceptBtn.addEventListener('click', function () {
            setConsentCookie();
            if (typeof localStorage !== 'undefined') localStorage.setItem(COOKIE_CONSENT_KEY, '1');
            bar.style.display = 'none';
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
