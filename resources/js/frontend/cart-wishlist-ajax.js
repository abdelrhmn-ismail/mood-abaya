/**
 * AJAX add-to-cart and wishlist: no page reload, show loader, update navbar counts and button state.
 */

const NAV_CART_IDS = ['nav-cart-count', 'nav-cart-count-mobile'];
const NAV_WISHLIST_IDS = ['nav-wishlist-count', 'nav-wishlist-count-mobile'];

function updateNavCount(ids, count) {
  const num = Number(count) || 0;
  ids.forEach((id) => {
    const el = document.getElementById(id);
    if (el) {
      el.textContent = num;
      el.style.display = num > 0 ? '' : 'none';
    }
  });
}

export function updateNavbarCartCount(count) {
  updateNavCount(NAV_CART_IDS, count);
}

export function updateNavbarWishlistCount(count) {
  updateNavCount(NAV_WISHLIST_IDS, count);
}

function setButtonLoading(btn, loading) {
  if (!btn) return;
  if (loading) {
    btn.dataset.originalText = btn.innerHTML;
    btn.disabled = true;
    btn.classList.add('relative', 'overflow-hidden');
    btn.innerHTML =
      '<span class="inline-flex h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent" aria-hidden="true"></span>';
  } else if (btn.dataset.originalText !== undefined) {
    btn.disabled = false;
    btn.classList.remove('relative', 'overflow-hidden');
    btn.innerHTML = btn.dataset.originalText;
    delete btn.dataset.originalText;
  }
}

function markCartButtonAdded(btn) {
  if (!btn) return;
  const wrap = btn.closest('[data-ajax-cart]');
  if (wrap) wrap.dataset.inCart = '1';
  btn.disabled = true;
  const textSpan = btn.querySelector('.cart-btn-text');
  if (textSpan) textSpan.textContent = btn.dataset.addedLabel || 'In cart';
  else btn.textContent = btn.dataset.addedLabel || 'In cart';
}

function markWishlistButtonAdded(form, inWishlist) {
  const wrap = form.closest('[data-wishlist-wrap]');
  if (!wrap) return;
  wrap.dataset.inWishlist = inWishlist ? '1' : '0';
  const removeForm = wrap.querySelector('form[data-wishlist-action="remove"]');
  const addForm = wrap.querySelector('form[data-wishlist-action="add"]');
  if (removeForm) removeForm.style.display = inWishlist ? '' : 'none';
  if (addForm) addForm.style.display = inWishlist ? 'none' : '';
}

function initCartForms() {
  document.addEventListener('submit', async (e) => {
    const form = e.target;
    if (!form.matches('[data-ajax-cart]')) return;
    if (form.dataset.inCart === '1') {
      e.preventDefault();
      return;
    }
    e.preventDefault();
    const btn = form.querySelector('button[type="submit"]');
    setButtonLoading(btn, true);
    try {
      const res = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          Accept: 'application/json',
          ...(form.querySelector('[name="_token"]')
            ? { 'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value }
            : {}),
        },
      });
      const data = await res.json().catch(() => ({}));
      if (res.ok && data.cart_count !== undefined) {
        updateNavbarCartCount(data.cart_count);
        setButtonLoading(btn, false);
        markCartButtonAdded(btn);
      } else {
        setButtonLoading(btn, false);
        if (data.message) alert(data.message);
      }
    } catch (err) {
      setButtonLoading(btn, false);
      console.error(err);
    }
  });
}

function initWishlistForms() {
  document.addEventListener('submit', async (e) => {
    const form = e.target;
    if (!form.closest('[data-ajax-wishlist]') && !form.dataset.ajaxWishlist) return;
    const isWishlist = form.action.includes('wishlist');
    if (!isWishlist) return;
    e.preventDefault();
    const btn = form.querySelector('button[type="submit"]');
    setButtonLoading(btn, true);
    try {
      const methodInput = form.querySelector('[name="_method"]');
      const method = methodInput ? methodInput.value : form.method;
      const res = await fetch(form.action, {
        method: method,
        body: new FormData(form),
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          Accept: 'application/json',
          ...(form.querySelector('[name="_token"]')
            ? { 'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value }
            : {}),
        },
      });
      const data = await res.json().catch(() => ({}));
      if (res.ok && (data.wishlist_count !== undefined || data.ok)) {
        if (data.wishlist_count !== undefined) updateNavbarWishlistCount(data.wishlist_count);
        const inWishlist = data.in_wishlist === true || data.added === true;
        markWishlistButtonAdded(form, inWishlist);
      }
      setButtonLoading(btn, false);
    } catch (err) {
      setButtonLoading(btn, false);
      console.error(err);
    }
  });
}

export function initCartWishlistAjax() {
  initCartForms();
  initWishlistForms();
}
