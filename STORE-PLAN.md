# Mood Abaya Store – Laravel + Bootstrap 5 Plan

A simple e-commerce store with categories, products, cart, multiple payment methods (cash, bank upload + approval, Tamara), and full admin control. Structured for **video coding sessions** with an AI agent.

**Architecture:** **Nwidart Laravel Modules** + **Service layer** (all business logic in services; controllers are thin).

---

## Tech Stack

| Layer        | Choice                          |
|-------------|----------------------------------|
| Backend     | Laravel 12.x                     |
| Structure   | nWidart/laravel-modules          |
| Logic       | Services (all business logic)   |
| Frontend    | Blade + Bootstrap 5              |
| Database    | MySQL / SQLite                   |
| Auth        | Laravel Breeze or Fortify        |
| File upload | Laravel Storage (bank receipts)  |
| Payments    | Cash (manual), Bank (upload), Tamara API |

---

## Architecture: Nwidart Modules + Services

### Module structure (per module)

Each module lives under `Modules/<ModuleName>/` with:

- **Routes** – `routes/web.php` (and `api.php` if needed)
- **Controllers** – HTTP only: validate input, call service, return view/redirect
- **Services** – all business logic (cart logic, order creation, payment processing, etc.)
- **Models** – Eloquent models used by that module (or shared in `app/Models`)
- **Views** – Blade templates under `resources/views/`
- **Config** – `config/config.php` if needed

**Rule:** Controllers must **not** contain business logic. They only: read request → call service method(s) → return response (view/redirect/JSON).

### Modules to create

| Module    | Responsibility                                      | Main services |
|-----------|------------------------------------------------------|----------------|
| **Core**  | Home, About, layout, shared layout/partials         | (optional) `HomeService` for featured data |
| **Shop**  | Categories list, products list, product detail      | `CategoryService`, `ProductService` |
| **Cart**  | Add/update/remove cart, cart total, merge on login  | `CartService` |
| **Order** | Checkout, order creation, order history              | `OrderService`, `CheckoutService` |
| **Payment** | Cash, bank upload, bank approval, Tamara          | `PaymentService`, `BankPaymentService`, `TamaraService` |
| **Contact** | Contact form, save message                        | `ContactService` |
| **Account** | Profile, order history (customer view)            | `AccountService` |
| **Admin** | Dashboard, orders, payments, shipping, products, categories, contact messages | `Admin\DashboardService`, `Admin\OrderService`, `Admin\PaymentService`, `Admin\ShippingService`, `Admin\ProductService`, `Admin\CategoryService`, `Admin\ContactMessageService` |

Models can live in `app/Models` (shared) or inside each module’s `Entities`/`Models` depending on preference; the plan assumes **shared** `app/Models` for simplicity so modules stay decoupled but reuse the same Eloquent models.

---

## Services Reference (all logic lives here)

| Service | Module | Responsibility / methods |
|---------|--------|---------------------------|
| **HomeService** | Core | `getFeaturedCategories()`, `getLatestProducts()` |
| **CategoryService** | Shop | `getActiveCategories()`, `findBySlug(string $slug)`, `getProductsByCategory(Category $category)` |
| **ProductService** | Shop | `getActiveProducts()`, `findBySlug(string $slug)`, `searchByName(string $q)` |
| **CartService** | Cart | `getCart()`, `addItem($productId, $qty)`, `updateQuantity($itemId, $qty)`, `removeItem($itemId)`, `getTotal()`, `mergeGuestCartToUser($userId)` |
| **CheckoutService** | Order | `getCheckoutData()`, `placeOrder(array $address, string $paymentMethod, $proofFile = null)` → creates Order + OrderItems + Payment, clears cart |
| **OrderService** | Order | `getOrdersForUser($userId)`, `findOrderForUser($orderId, $userId)`, `getOrderByNumber($number)` |
| **PaymentService** | Payment | `createPaymentForOrder(Order $order, string $method, ?string $proofPath)`, `markAsPaid(Payment $payment)`, `approveBankPayment(Payment $payment)`, `rejectBankPayment(Payment $payment)` |
| **BankPaymentService** | Payment | `storeProof(UploadedFile $file)` → path, `getPaymentsPendingApproval()` |
| **TamaraService** | Payment | `createCheckoutSession(Order $order)` → redirect URL, `handleReturn(array $params)` → confirm payment, update Payment |
| **ContactService** | Contact | `submitMessage(array $data)` → ContactMessage |
| **AccountService** | Account | `getProfile(User $user)`, `updateProfile(User $user, array $data)`, `getOrderHistory(User $user)` |
| **DashboardService** | Admin | `getCounts()` (orders, pending payments, unread contacts), `getRecentOrders()` |
| **Admin\OrderService** | Admin | `getOrders($filters)`, `getOrder($id)`, `updateOrderStatus(Order $order, string $status)` |
| **Admin\PaymentService** | Admin | `getPayments($filters)`, `getPayment($id)`, approve/reject (delegate to PaymentService) |
| **Admin\ShippingService** | Admin | `getShippings()`, `createOrUpdate(Order $order, array $data)`, `markShipped(Order $order, $carrier, $trackingNumber)` |
| **Admin\ProductService** | Admin | `getAll($filters)`, `create(array $data)`, `update(Product $product, array $data)`, `delete(Product $product)` |
| **Admin\CategoryService** | Admin | `getAll()`, `create(array $data)`, `update(Category $category, array $data)`, `delete(Category $category)` |
| **Admin\ContactMessageService** | Admin | `getMessages()`, `markAsRead(ContactMessage $message)` |

Controllers only call these services and return views/redirects; no business logic in controllers.

---

## Enums / Constants

Use **PHP enums** (Laravel 9+) or a shared config file so the same values are used in migrations, models, services, and Blade views.

| Type | Values | Usage |
|------|--------|--------|
| **Order status** | `pending`, `processing`, `shipped`, `delivered`, `cancelled` | `orders.status`; admin order list/detail; customer order history |
| **Payment status** | `pending`, `pending_approval`, `paid`, `rejected`, `failed` | `payments.status`, `orders.payment_status`; checkout and admin |
| **Payment method** | `cash`, `bank`, `tamara` | `orders.payment_method`, `payments.method`; checkout form and payment flow |

**Implementation:** Create `app/Enums/OrderStatus.php`, `app/Enums/PaymentStatus.php`, `app/Enums/PaymentMethod.php` (backed enums with string values), or use `config/orders.php` returning arrays. Use enum/value in migrations (defaults), model casts, services (e.g. `OrderStatus::Pending`), and Blade (e.g. `@foreach(OrderStatus::cases())` or config array).

---

## Validation & Form Requests

Create **Form Request** classes and use them in the corresponding controllers. Controllers only type-hint the request; validation rules live in the Form Request.

| Form Request | Module | Used in | Main rules |
|--------------|--------|---------|------------|
| **ContactRequest** | Contact | ContactController::store | name (required, string), email (required, email), subject (required, string), message (required, string) |
| **CheckoutRequest** | Order | CheckoutController::store | Shipping: full_name, phone, address, city, etc. (required). payment_method (required, in:cash,bank,tamara). payment_proof: required_if:payment_method,bank; file; mimes:jpg,jpeg,png,pdf; max:5120 (5 MB) |
| **ProfileUpdateRequest** | Account | AccountController::update | name, email (unique except current user), phone (nullable) |
| **StoreCategoryRequest** | Admin | Admin CategoryController::store | name, slug (nullable, auto from name), description (nullable), image (nullable, image, max:2048), sort_order (integer), active (boolean) |
| **UpdateCategoryRequest** | Admin | Admin CategoryController::update | Same as Store; image optional |
| **StoreProductRequest** | Admin | Admin ProductController::store | category_id, name, slug (nullable), description (nullable), price (numeric, min:0), image(s) (image, max:2048), stock (integer, min:0), active (boolean) |
| **UpdateProductRequest** | Admin | Admin ProductController::update | Same as Store; images optional |

**File rules summary:**

- **Bank receipt (payment proof):** `mimes:jpg,jpeg,png,pdf`, `max:5120` (5 MB). Validate in CheckoutRequest when `payment_method === 'bank'`.
- **Product / category images:** `image` (or `mimes:jpg,jpeg,png,webp`), `max:2048` (2 MB) per file.

---

## Stock / Inventory

- **On place order:** In **CheckoutService::placeOrder()** (or a dedicated inventory step), after creating the order and order items, **reduce product stock** by the quantity ordered for each line. Use a DB transaction so order creation and stock deduction succeed or fail together.
- **Cart:**
  - **Add to cart:** Do not allow adding more than available stock. In **CartService::addItem()**, cap quantity to `min(requested_qty, product->stock)`. If stock is 0, return error or do not add.
  - **Update quantity:** When updating cart item quantity, cap to current product stock (e.g. **CartService::updateQuantity()**).
- **Admin:**
  - Optional **low stock** alert or column: e.g. show a badge or column when `stock < threshold` (e.g. 5). Implement in Admin Product list view and optionally in **Admin\ProductService::getAll()** (e.g. append `is_low_stock`).
- **Checkout:**
  - Optional but recommended: **Before placing order**, validate that every cart item has sufficient stock (e.g. in CheckoutService::placeOrder() or in CheckoutRequest / controller). If any item has insufficient stock, **prevent checkout** and return a clear message (e.g. "Product X has only Y items in stock") and redirect back to cart or checkout.

---

## Phase 0: Project Setup (Video 1)

**Goal:** Fresh Laravel app, nWidart modules, Bootstrap 5, base layout, and routing.

1. Create Laravel project: `composer create-project laravel/laravel .`
2. Install **nWidart/laravel-modules**: `composer require nwidart/laravel-modules` then `php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"` and set `modules` path in `config/modules.php` (default: `Modules` in project root).
3. Create **Core** module: `php artisan module:make Core` (or create first for layout/routes).
4. Install Bootstrap 5 (CDN or NPM + Vite). Put main layout in **Core** or in `resources/views/layouts`: `app.blade.php` with navbar (Home, About, Contact, Categories, Cart, Login/Register), footer, `@yield('content')`, Bootstrap 5 CSS/JS.
5. Configure `.env` (DB, APP_NAME).
6. Run migrations: `php artisan migrate`.
7. In **Core** (or main `routes/web.php`), register **placeholder routes**: `home`, `about`, `contact`, `categories`, `cart`, `login`, `register`. Later these can be moved to respective modules.

**Deliverable:** App runs, layout loads, nWidart modules ready, all main links exist.

---

## Phase 1: Static Pages (Video 2)

**Goal:** Home, About Us, Contact Us as simple Blade views. **Module:** Core, Contact.

1. **Core module:** Home (`/`), About (`/about`) – hero, static content; optional `HomeService` for static data.
2. **Contact module:** Create `php artisan module:make Contact`. Add **ContactService** with `submitMessage(array $data)`. Create `contact_messages` migration + `ContactMessage` model (in `app/Models`). Contact controller: validate request → `ContactService::submitMessage()` → redirect with success.
3. **Contact Us** (`/contact`): Form (name, email, subject, message); controller calls service only.
4. **Categories** index: In Shop module (Phase 3) or placeholder in Core; for now simple Blade with static/fake data.

**Deliverable:** All static/public pages working; Contact uses ContactService; no logic in controllers.

---

## Phase 2: Database & Models (Video 3)

**Goal:** Core schema and Eloquent models. **Location:** Shared `app/Models` (used by all modules).

**Migrations to create** (in `database/migrations` or per-module if you prefer):

| Table             | Main columns |
|-------------------|--------------|
| `users`           | (default + optional: phone, avatar, is_admin) |
| `categories`      | id, name, slug, description, image, sort_order, active |
| `products`        | id, category_id, name, slug, description, price, image(s), stock, active |
| `cart_items`      | id, user_id (nullable), session_id, product_id, quantity |
| `orders`          | id, user_id, order_number, status, payment_method, payment_status, shipping_address, notes, total |
| `order_items`     | id, order_id, product_id, quantity, price |
| `payments`        | id, order_id, method (cash/bank/tamara), status, proof_path (for bank), reference, approved_at, approved_by |
| `contact_messages`| id, name, email, subject, message, read_at |
| `shippings`       | id, order_id, carrier, tracking_number, status, shipped_at |

**Models:**  
`User`, `Category`, `Product`, `CartItem`, `Order`, `OrderItem`, `Payment`, `ContactMessage`, `Shipping` with relationships. No business logic in models (only relations, casts, fillable).

**Seeders:**  
Categories and a few products; one admin user.

**Deliverable:** Migrations run, models and seeders working; ready for services to use.

---

## Phase 3: Categories & Products (Video 4)

**Goal:** Categories list, product listing by category, product detail page. **Module:** Shop. **Services:** CategoryService, ProductService.

1. Create **Shop** module: `php artisan module:make Shop`.
2. **CategoryService:** `getActiveCategories()`, `findBySlug(string $slug)`, `getProductsByCategory(Category $category)`.
3. **ProductService:** `findBySlug(string $slug)`, optional `searchByName(string $q)`.
 “Add to cart” button.
4. **Controllers (thin):** CategoryController / ProductController only call services and return view.
5. **Routes:** `/categories`, `/categories/{slug}`, `/products/{slug}`. Views: Bootstrap 5 cards and grid; product detail with Add to cart button.
6. Images in `storage/app/public`; `php artisan storage:link`.

**Deliverable:** Shop module with CategoryService + ProductService; controllers only call services and return views.

---

## Phase 4: Cart (Video 5)

**Goal:** Add to cart, view cart, update quantity, remove item. **Module:** Cart. **Service:** CartService.

1. **Cart storage:** Use `session_id` for guests and `user_id` for logged-in users (merge guest cart on login later).
2. **Routes:**  
   - `GET /cart` – show cart.  
   - `POST /cart` – add item (product_id, quantity).  
   - `PATCH /cart/{item}` – update quantity.  
   - `DELETE /cart/{item}` – remove item.
3. **Cart page:** Table/list with image, name, price, quantity input, line total, remove; total at bottom; “Proceed to checkout” (to Phase 5).
4. **Navbar:** Cart icon with item count (from session/DB).

**Deliverable:** Guest and (later) user can add/update/remove cart items and see total.

---

## Phase 5: Auth – Register, Login, Account (Video 6)

**Goal:** Registration, login, and simple account area. **Module:** Account. **Service:** AccountService; cart merge in CartService.

1. Install **Laravel Breeze** (Blade stack): `composer require laravel/breeze --dev && php artisan breeze:install blade`.
2. **Account page** (`/account` or `/dashboard` for customers):
   - Profile: name, email, phone (optional).
   - Order history: list of customer orders with status and link to order detail.
3. **Middleware:** Ensure `/account` and checkout require auth; redirect guest to login with “redirect back after login”.
4. **Cart merge:** On login, merge session cart into user cart (same `CartItem` model, update `session_id` → `user_id` or merge quantities).

**Deliverable:** Users can register, log in, and see profile + order history.

---

## Phase 6: Checkout & Orders (Video 7)

**Goal:** Checkout flow and order creation.**Modules:** Order, Payment. **Services:** CheckoutService, OrderService, PaymentService, BankPaymentService.

1. **Checkout page** (`/checkout`):
   - Show cart summary (read-only).
   - Shipping address form (full name, phone, address, city, etc.).
   - **Payment method choice:** Radio buttons: Cash, Bank Transfer (upload), Tamara.
2. **Order creation:**
   - Validate cart and address.
   - Create `Order` + `OrderItem` from cart.
   - Create `Payment` row with method; if “bank”, leave proof_path empty until upload.
   - Clear cart (and optionally move to “order confirmed” page).
3. **Bank payment:**  
   - After choosing “Bank”, show file input for receipt image/PDF.  
   - Store file in `storage/app/public/payments` and save path in `payments.proof_path`.  
   - Set `payment_status` = `pending_approval`.
4. **Order confirmation page:**  
   - Show order number, status, and “we’ll contact you” for cash/bank; for Tamara redirect in next phase.

**Deliverable:** User can place order with cash or bank (with upload); order and payment records saved.

---

## Phase 7: Payment Methods – Cash, Bank Approval, Tamara (Video 8)

**Goal:** Implement the three payment flows. **Module:** Payment. **Services:** PaymentService, BankPaymentService, TamaraService.

1. **Cash:**  
   - Order created with `payment_method = cash`, `payment_status = pending`.  
   - Admin can later mark as “paid” (Phase 9).
2. **Bank (upload + approval):**  
   - Already have upload and `pending_approval`.  
   - Admin approves/rejects and sets `payment_status` (Phase 9).  
   - Optional: email customer when approved.
3. **Tamara:**  
   - Register at [Tamara](https://tamara.co).  
   - Use Tamara API (checkout session or payment link).  
   - Flow: create order with `payment_method = tamara`, redirect user to Tamara; webhook or return URL to confirm payment and update `payments` (e.g. `payment_status = paid`, store Tamara reference).  
   - Show “Pay with Tamara” on checkout and handle return URL.

**Deliverable:** All three payment methods wired; Tamara optional if you want to do “cash + bank” first and add Tamara in a follow-up video.

---

## Phase 8: Admin – Foundation (Video 9)

**Goal:** Admin area and access control. **Module:** Admin. **Service:** DashboardService.

1. Create **Admin** module: `php artisan module:make Admin`.
2. **Admin middleware:** e.g. `is_admin` (check `users.is_admin` or `users.role`). Route prefix `admin`, middleware `auth`, `admin`.
3. **DashboardService:** `getCounts()` (orders, pending payments, unread contacts), `getRecentOrders()`.
4. **Admin layout:** `Modules/Admin/resources/views/layouts/admin.blade.php` – Bootstrap 5 sidebar: Dashboard, Orders, Payments, Products, Categories, Contact messages, Shipping.
5. **Controllers:** DashboardController only calls DashboardService::getCounts(), getRecentOrders(); returns view. Seeder: one admin user.

**Deliverable:** Admin module with DashboardService; controllers thin; admin can see dashboard and sidebar.

---

## Phase 9: Admin – Orders, Payments, Shipping (Video 10)

**Goal:** Admin manages orders, approves payments, and tracks shipping. **Module:** Admin. **Services:** Admin\OrderService, Admin\PaymentService, Admin\ShippingService, Admin\ContactMessageService.

1. **Orders list:**  
   - Table: order #, customer, date, total, payment method, payment status, order status.  
   - Filter by status; link to order detail.
2. **Order detail:**  
   - Customer info, items, total.  
   - Change order status (e.g. processing, shipped, delivered).  
   - For **cash:** button “Mark as paid”.  
   - For **bank:** show uploaded proof (image/link); buttons “Approve” / “Reject” and set `payment_status`.
3. **Payments list:**  
   - All payments with status; filter by pending approval (bank).
4. **Shipping:**  
   - Form per order: carrier, tracking number, “Mark as shipped” (set `shipped_at`, create/update `Shipping`).  
   - Optional: email customer with tracking link.
5. **Contact messages:**  
   - List with “read” flag; mark as read when opened.

**Deliverable:** Admin can track orders, approve bank payments, and manage shipping.

---

## Phase 10: Admin – Products & Categories (Video 11)

**Goal:** Full CRUD for products and categories. **Module:** Admin. **Services:** Admin\CategoryService, Admin\ProductService.

1. **Admin\CategoryService:** `getAll()`, `create(array $data)`, `update(Category $category, array $data)`, `delete(Category $category)`. Slug from name; image upload to storage.
2. **Admin\ProductService:** `getAll($filters)`, `create(array $data)`, `update(Product $product, array $data)`, `delete(Product $product)`. Images in `storage/app/public/products`.
3. **Controllers:** Admin CategoryController and ProductController only validate (Form Requests) and call admin services; return views. No business logic in controllers.

**Deliverable:** Admin CRUD for categories and products; all logic in Admin\CategoryService and Admin\ProductService.

---

## Phase 11: Polish & UX (Video 12)

**Goal:** Final touches for a simple but complete store. **Services:** HomeService (Core); OrderService for customer order detail.

1. **Home page:**  
   - Dynamic: featured categories (from DB), latest products.
2. **Account – Order detail:**  
   - Customer view: order summary, payment status, shipping status, tracking number (if shipped).
3. **Flash messages:**  
   - Success/error for cart, checkout, contact, admin actions (Bootstrap alerts).
4. **Empty states:**  
   - Empty cart, no orders, no products in category.
5. **Responsive:**  
   - Ensure navbar, cart, and forms work on mobile (Bootstrap 5).
6. **Optional:**  
   - Email on order placed; email when payment approved or order shipped.

**Deliverable:** Store and admin feel complete and consistent.

---

## Suggested Video Order Summary

| Video | Phase   | Focus (modules + services)                          |
|-------|--------|-----------------------------------------------------|
| 1     | 0      | Laravel + nWidart + Bootstrap 5 + layout + routes  |
| 2     | 1      | Core, Contact modules; ContactService               |
| 3     | 2      | DB schema, models (app/Models), seeders             |
| 4     | 3      | Shop module; CategoryService, ProductService        |
| 5     | 4      | Cart module; CartService                            |
| 6     | 5      | Account module; AccountService; cart merge          |
| 7     | 6      | Order, Payment modules; CheckoutService, PaymentService, BankPaymentService |
| 8     | 7      | Payment module; PaymentService, TamaraService      |
| 9     | 8      | Admin module; DashboardService                     |
| 10    | 9      | Admin; OrderService, PaymentService, ShippingService, ContactMessageService |
| 11    | 10     | Admin; CategoryService, ProductService (CRUD)      |
| 12    | 11     | HomeService, polish, emails (optional)              |

---

## File Structure (Reference) – Nwidart Modules + Services

```
app/
  Models/                    # Shared Eloquent models (used by all modules)
    User.php, Category.php, Product.php, CartItem.php,
    Order.php, OrderItem.php, Payment.php, ContactMessage.php, Shipping.php

Modules/
  Core/
    app/
      Http/Controllers/
      Services/
        HomeService.php
    resources/views/
    routes/web.php
  Shop/
    app/
      Http/Controllers/
      Services/
        CategoryService.php
        ProductService.php
    resources/views/
    routes/web.php
  Cart/
    app/
      Http/Controllers/
      Services/
        CartService.php
    resources/views/
    routes/web.php
  Order/
    app/
      Http/Controllers/
      Services/
        OrderService.php
        CheckoutService.php
    resources/views/
    routes/web.php
  Payment/
    app/
      Http/Controllers/
      Services/
        PaymentService.php
        BankPaymentService.php
        TamaraService.php
    resources/views/
    routes/web.php
  Contact/
    app/
      Http/Controllers/
      Services/
        ContactService.php
    resources/views/
    routes/web.php
  Account/
    app/
      Http/Controllers/
      Services/
        AccountService.php
    resources/views/
    routes/web.php
  Admin/
    app/
      Http/Controllers/
      Services/
        DashboardService.php
        OrderService.php
        PaymentService.php
        ShippingService.php
        ProductService.php
        CategoryService.php
        ContactMessageService.php
    resources/views/
    routes/web.php

resources/views/
  layouts/
    app.blade.php            # Frontend layout (or in Core)
    admin.blade.php          # Admin layout (or in Admin module)

routes/
  web.php                    # May only load module routes
  auth.php                   # Breeze
```

**Rule:** Controllers live in each module and only call that module’s Services; all business logic stays in Services.

---

## Notes for Video Coding with AI Agent

- **One phase per video:** Keeps each session focused and easy to re-record.
- **Commit per phase:** So you can revert or branch if needed.
- **Nwidart modules:** Create one module per phase when introduced; put Controllers and **Services** inside the module (`Modules/<Name>/app/Services/`). Controllers only call services.
- **Service layer:** All business logic goes in Service classes. Controllers: validate request → call service method(s) → return view/redirect. No domain logic in controllers.
- **Bootstrap 5:** Use components (navbar, cards, forms, tables, alerts) for consistency.
- **Naming:** Use same terms in plan and code (e.g. `payment_status`, `pending_approval`) so the AI can follow.
- **Tamara:** Start with sandbox; document API keys in `.env` and keep them out of the repo.

You can use this plan as the script for each video: implement the phase step-by-step with the AI agent, then move to the next phase in the next video.
