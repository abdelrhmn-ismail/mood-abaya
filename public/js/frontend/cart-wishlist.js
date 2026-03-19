/**
 * AJAX add-to-cart and wishlist – no page reload, updates navbar counts
 */
(function () {
    'use strict';

    var NAV_CART_IDS = ['nav-cart-count', 'nav-cart-count-mobile'];
    var NAV_WISHLIST_IDS = ['nav-wishlist-count', 'nav-wishlist-count-mobile'];

    function updateNavCount(ids, count) {
        var num = Number(count) || 0;
        ids.forEach(function (id) {
            var el = document.getElementById(id);
            if (el) {
                el.textContent = num;
                el.style.display = num > 0 ? '' : 'none';
            }
        });
    }

    window.updateNavbarCartCount = function (count) {
        updateNavCount(NAV_CART_IDS, count);
    };

    window.updateNavbarWishlistCount = function (count) {
        updateNavCount(NAV_WISHLIST_IDS, count);
    };

    function setButtonLoading(btn, loading) {
        if (!btn) return;
        if (loading) {
            btn.dataset.originalText = btn.innerHTML;
            btn.disabled = true;
            btn.classList.add('relative', 'overflow-hidden');
            btn.innerHTML = '<span class="inline-flex h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent" aria-hidden="true"></span>';
        } else if (btn.dataset.originalText !== undefined) {
            btn.disabled = false;
            btn.classList.remove('relative', 'overflow-hidden');
            btn.innerHTML = btn.dataset.originalText;
            delete btn.dataset.originalText;
        }
    }

    function markCartButtonAdded(btn) {
        if (!btn) return;
        var wrap = btn.closest('[data-ajax-cart]');
        if (wrap) wrap.dataset.inCart = '1';
        btn.disabled = true;
        var textSpan = btn.querySelector('.cart-btn-text');
        if (textSpan) textSpan.textContent = btn.dataset.addedLabel || 'In cart';
        else btn.textContent = btn.dataset.addedLabel || 'In cart';
    }

    function markWishlistButtonAdded(form, inWishlist) {
        var wrap = form.closest('[data-wishlist-wrap]');
        if (!wrap) return;
        wrap.dataset.inWishlist = inWishlist ? '1' : '0';
        var removeForm = wrap.querySelector('form[data-wishlist-action="remove"]');
        var addForm = wrap.querySelector('form[data-wishlist-action="add"]');
        if (removeForm) removeForm.style.display = inWishlist ? '' : 'none';
        if (addForm) addForm.style.display = inWishlist ? 'none' : '';
    }

    function getHeaders(form) {
        var tokenInput = form.querySelector('[name="_token"]');
        var headers = { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' };
        if (tokenInput) headers['X-CSRF-TOKEN'] = tokenInput.value;
        return headers;
    }

    function initCartForms() {
        document.addEventListener('submit', function (e) {
            var form = e.target;
            if (!form.matches('[data-ajax-cart]')) return;
            if (form.dataset.inCart === '1') { e.preventDefault(); return; }
            e.preventDefault();
            var btn = form.querySelector('button[type="submit"]');
            setButtonLoading(btn, true);
            fetch(form.action, { method: 'POST', body: new FormData(form), headers: getHeaders(form) })
                .then(function (res) { return res.json().catch(function () { return {}; }).then(function (d) { return { ok: res.ok, data: d }; }); })
                .then(function (r) {
                    if (r.ok && r.data.cart_count !== undefined) {
                        window.updateNavbarCartCount(r.data.cart_count);
                        setButtonLoading(btn, false);
                        markCartButtonAdded(btn);
                        if (r.data.cart && window.CartDrawerAPI) {
                            window.CartDrawerAPI.loadFromPayload(r.data.cart);
                        } else {
                            window.dispatchEvent(new CustomEvent('cart-drawer-open'));
                        }
                    } else {
                        setButtonLoading(btn, false);
                        if (r.data.message) alert(r.data.message);
                    }
                })
                .catch(function () { setButtonLoading(btn, false); });
        });
    }

    function initWishlistForms() {
        document.addEventListener('submit', function (e) {
            var form = e.target;
            if (!form.closest('[data-ajax-wishlist]') && !form.dataset.ajaxWishlist) return;
            if (form.action.indexOf('wishlist') === -1) return;
            e.preventDefault();
            var btn = form.querySelector('button[type="submit"]');
            setButtonLoading(btn, true);
            var methodInput = form.querySelector('[name="_method"]');
            var method = methodInput ? methodInput.value : form.method;
            fetch(form.action, { method: method, body: new FormData(form), headers: getHeaders(form) })
                .then(function (res) { return res.json().catch(function () { return {}; }).then(function (d) { return { ok: res.ok, data: d }; }); })
                .then(function (r) {
                    if (r.ok && (r.data.wishlist_count !== undefined || r.data.ok)) {
                        if (r.data.wishlist_count !== undefined) window.updateNavbarWishlistCount(r.data.wishlist_count);
                        var inWishlist = r.data.in_wishlist === true || r.data.added === true;
                        markWishlistButtonAdded(form, inWishlist);
                    }
                    setButtonLoading(btn, false);
                })
                .catch(function () { setButtonLoading(btn, false); });
        });
    }

    function init() {
        initCartForms();
        initWishlistForms();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
