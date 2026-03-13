# Mood Abaya Store – Progress Notes

Summary of what has been finished, following `STORE-PLAN.md`. **Phases 0–11 are implemented.**

---

## Phase 0: Project Setup ✅

- Laravel 12, nWidart/laravel-modules, Tailwind, base layout
- **Settings** table + `Setting` model (`get`, `set`, `locale`, `defaultTheme`)
- **SetLocaleFromSetting** middleware; `lang/en.json`, `lang/ar.json`
- **Core** module: placeholder routes (home, about, cart, login, register)
- **Contact** module: contact form (Phase 1)
- Layout: `dir`/`lang` from locale; theme (light/dark) via cookie + `theme.js` toggle
- Composer merge-plugin for `Modules/*/composer.json` autoload

---

## Phase 1: Static Pages ✅

- **Core:** Home (`/`), About (`/about`) – Blade views
- **Contact module:** ContactService, `contact_messages` migration, ContactMessage model
- **Contact Us** (`/contact`): form (name, email, subject, message); controller → ContactService only
- Success flash and validation

---

## Phase 2: Database & Models ✅

### Migrations added

| Migration | Purpose |
|-----------|---------|
| `add_optional_columns_to_users_table` | phone, avatar, is_admin |
| `create_categories_table` | name, slug, description, image, sort_order, active |
| `create_products_table` | category_id, name, slug, description, price, image, stock, active |
| `create_cart_items_table` | user_id (nullable), session_id, product_id, quantity |
| `create_orders_table` | user_id, order_number, status, payment_method, payment_status, shipping_address, notes, total |
| `create_order_items_table` | order_id, product_id, quantity, price |
| `create_payments_table` | order_id, method, status, proof_path, reference, approved_at, approved_by |
| `add_read_at_to_contact_messages_table` | read_at on contact_messages |
| `create_shippings_table` | order_id, carrier, tracking_number, status, shipped_at |

### Models (in `app/Models`)

- **Category** – relations, `active` scope
- **Product** – relations, `active` scope
- **CartItem**, **Order**, **OrderItem**, **Payment**, **Shipping** – fillable and relations
- **User** – phone, avatar, is_admin, orders(), cartItems()
- **ContactMessage** – read_at cast

### Seeders

- **CategorySeeder** – Abayas, Jilbabs, Hijabs
- **ProductSeeder** – 4 sample products in those categories
- **AdminUserSeeder** – admin@moodabaya.com / password
- **DatabaseSeeder** – runs the above seeders

---

## Phase 3: Shop Module (Categories & Products) ✅

### Shop module

- **CategoryService** – getActiveCategories(), findBySlug($slug), getProductsByCategory($category)
- **ProductService** – getActiveProducts(), findBySlug($slug), searchByName($q)
- **CategoryController** – index (categories list), show (products in category)
- **ProductController** – show (product detail)

### Routes (Shop)

- `GET /categories` → categories list
- `GET /categories/{slug}` → category page with products
- `GET /products/{slug}` → product detail

### Views

- **frontend/categories** – grid of categories (from DB)
- **frontend/category** – breadcrumb, category name/description, product grid with links
- **frontend/product** – image, name, price, description, stock, “Add to Cart” (links to cart for Phase 4)

### Core

- **HomeService** – getFeaturedCategories(), getLatestProducts()
- **HomeController** – passes categories and products to home view
- **frontend/home** – dynamic categories and featured products, links to categories, categories.show, products.show, and cart

### Other

- `php artisan storage:link` run for product/category images
- Core’s placeholder `/categories` removed; Shop owns category and product routes
- New translation keys in `lang/en.json` and `lang/ar.json` (e.g. SAR, In stock, Out of stock, No products yet)

---

## Phase 4: Cart ✅

- **Cart module:** CartService (getCart, getItemCount, addItem, updateQuantity, removeItem, getTotal, mergeGuestCartToUser, clearCart)
- **Routes:** GET /cart, POST /cart, PATCH /cart/{item}, DELETE /cart/{item}
- **Cart page:** List with image, name, price, quantity input, line total, remove; total; “Proceed to Checkout” (link when route exists)
- **Navbar:** Cart count badge via View Composer (CartServiceProvider)
- **Add to Cart:** Product and home pages POST to cart.store; Core’s /cart placeholder removed

---

## Phase 5: Auth & Account ✅

- **Laravel Breeze** (Blade) installed; auth routes in `routes/auth.php` (login, register, logout, password reset, etc.)
- **Cart merge on login:** `AuthenticatedSessionController::store()` calls `CartService::mergeGuestCartToUser()` after authentication
- **Account page** (`/account`): Profile (name, email, phone) + Order history (list with order_number, date, status, total); uses frontend layout
- **AccountController** and `frontend/account` view; profile edit links to Breeze’s profile.edit
- **Navbar:** Login/Register for guests; Account + Logout for authenticated users
- **Redirect after login:** `intended(route('account'))`
- Core’s placeholder login/register routes removed so Breeze auth routes are used

---

## Phase 6: Checkout & Orders ✅

- **Order module:** CheckoutService (`getCheckoutData()`, `placeOrder(address, paymentMethod, proofFile)`), OrderService (`getOrderByNumberForUser`, etc.). Order number format: `MO-YYYYMMDD-00001`.
- **Payment module:** PaymentService (`createPaymentForOrder`, `markAsPaid`, `approveBankPayment`, `rejectBankPayment`), BankPaymentService (`storeProof(UploadedFile)`, `getPaymentsPendingApproval()`).
- **Routes (auth):** GET/POST `/checkout`, GET `/order-confirmed/{orderNumber}`.
- **Checkout page:** Cart summary, shipping form (full name, phone, address, city, notes), **payment method: Cash or Bank Transfer only** (no Tamara). Bank: file input for receipt (image/PDF), stored in `storage/app/public/payments`.
- **Order creation:** Order + OrderItems from cart, Payment row (cash → `pending`, bank → `pending_approval` + `proof_path`), cart cleared, redirect to order confirmation.
- **Order confirmation page:** Order number, total, payment method, “we’ll contact you” / bank “we received your proof” message.

---

## Phase 7: Payment Methods (Cash & Bank only – no Tamara) ✅

- **Cash:** Order with `payment_method = cash`, `payment_status = pending`. Admin can mark as paid later (Phase 9).
- **Bank:** Upload receipt at checkout; `proof_path` saved; `payment_status = pending_approval`. Admin can approve/reject later (Phase 9).
- **Tamara:** Not implemented (per requirement).

---

## Phase 8: Admin Foundation ✅

- **Admin** module: `php artisan module:make Admin`.
- **Admin middleware:** e.g. `IsAdmin` (check `users.is_admin`); route prefix `admin`; middleware `auth` + `admin`.
- **DashboardService:** `getCounts()` (orders, pending payments, unread contacts), `getRecentOrders()`.
- **Admin\SettingsService:** `getSettings()`, `updateSettings(array)` for locale and default theme.
- **Admin layout:** Tailwind sidebar: Dashboard, **Settings**, Orders, Payments, Products, Categories, Contact messages, Shipping.
- **Settings page** (`/admin/settings`): form for default **locale** (en/ar) and default **theme** (light/dark/system); POST via SettingsService.
- **DashboardController**, **SettingsController** (thin; call services only).
- Seeder: ensure at least one admin user exists (AdminUserSeeder already in Phase 2).

---

## Phase 9: Admin – Orders, Payments, Shipping, Contact Messages ✅

- **Orders list:** table (order #, customer, date, total, payment method/status, order status); filters; link to detail.
- **Order detail:** customer + items + total; change order status; for **cash** “Mark as paid”; for **bank** show proof + “Approve” / “Reject”.
- **Payments list:** all payments; filter by pending approval (bank).
- **Shipping:** per order: carrier, tracking number, “Mark as shipped” (`shipped_at`, create/update `Shipping`).
- **Contact messages:** list with read/unread; mark as read when opened.
- **Admin\OrderService**, **Admin\PaymentService**, **Admin\ShippingService**, **Admin\ContactMessageService** (and controllers that only call these).

## Phase 10: Admin – Products & Categories CRUD ✅

- **Admin\CategoryService:** `getAll()`, `create()`, `update()`, `delete()`; slug from name; image upload.
- **Admin\ProductService:** `getAll($filters)`, `create()`, `update()`, `delete()`; images in `storage/app/public/products`.
- Admin **CategoryController** and **ProductController** (validate + call admin services only).
- Admin views for categories and products (index, create, edit, etc.).

## Phase 11: Polish & UX ✅

- **Home:** already dynamic (featured categories, latest products).
- **Customer order detail:** e.g. route `orders.show` and “View” link in account order history; page showing single order.
- **Flash messages:** consistent success/error display (partially there; can be standardized).
- **RTL / dark mode polish:** layout already supports locale + theme; final tweaks for RTL and dark.

## Optional / not in scope
- **Tamara:** not implemented (cash & bank only).
- **AccountService** as a dedicated module: account page exists; plan’s AccountService could be added later for `getProfile`, `updateProfile`, `getOrderHistory` if desired.

---

*Phases 0–11 complete. Last updated after Phase 8–11 (Admin module, orders/payments/shipping/contacts, products & categories CRUD, customer order detail).*
