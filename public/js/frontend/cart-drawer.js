/**
 * Alpine.js CartDrawer component – slide-out cart panel with AJAX operations.
 */
function CartDrawer() {
    return {
        visible: false,
        loading: false,
        updating: null,
        items: [],
        subtotal: 0,
        count: 0,

        _routes: {
            items:   '/cart/items',
            update:  '/cart/',
            destroy: '/cart/',
        },

        _csrfToken: '',

        init: function () {
            var meta = document.querySelector('meta[name="csrf-token"]');
            this._csrfToken = meta ? meta.getAttribute('content') : '';
            window.CartDrawerAPI = this;
        },

        open: function () {
            this.visible = true;
            document.body.style.overflow = 'hidden';
            this.fetchItems();
        },

        close: function () {
            this.visible = false;
            document.body.style.overflow = '';
        },

        fetchItems: function () {
            var self = this;
            self.loading = true;
            fetch(self._routes.items, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                self.items = data.items || [];
                self.subtotal = data.subtotal || 0;
                self.count = data.count || 0;
                self.loading = false;
            })
            .catch(function () { self.loading = false; });
        },

        loadFromPayload: function (cart) {
            this.items = cart.items || [];
            this.subtotal = cart.subtotal || 0;
            this.count = cart.count || 0;
            this.visible = true;
            document.body.style.overflow = 'hidden';
        },

        changeQty: function (item, delta) {
            var newQty = item.quantity + delta;
            if (newQty < 1) return;
            var self = this;
            self.updating = item.id;

            fetch(self._routes.update + item.id, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': self._csrfToken
                },
                body: JSON.stringify({ quantity: newQty })
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.cart) {
                    self._applyCart(data.cart);
                }
                self.updating = null;
            })
            .catch(function () { self.updating = null; });
        },

        removeItem: function (item) {
            var self = this;
            self.updating = item.id;

            fetch(self._routes.destroy + item.id, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': self._csrfToken
                }
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.cart) {
                    self._applyCart(data.cart);
                }
                self.updating = null;
            })
            .catch(function () { self.updating = null; });
        },

        _applyCart: function (cart) {
            this.items = cart.items || [];
            this.subtotal = cart.subtotal || 0;
            this.count = cart.count || 0;
            if (typeof window.updateNavbarCartCount === 'function') {
                window.updateNavbarCartCount(this.count);
            }
        }
    };
}
