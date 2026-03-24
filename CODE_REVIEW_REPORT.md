# Code Review Report

**Project:** Mood Abaya — Laravel Modular E-Commerce  
**Date:** March 19, 2026  
**Scope:** Full codebase audit (namespaces, views, routes, orphaned files, code quality)

---

## Summary

| Severity | Count | Description |
|----------|-------|-------------|
| **Critical** | 20 | Will cause runtime errors / crashes |
| **Warning** | 5 | Should be fixed for reliability and consistency |
| **Info** | 13 | Best-practice improvements, cleanup |

---

## 1. CRITICAL — Invalid Route Names (19 occurrences)

Route names in Blog, Faq, and Testimonial admin views use `module::admin.*` syntax, but Laravel route names don't use `::`. These will throw `RouteNotFoundException` at runtime.

### Blog Module

| File | Line | Current (broken) | Correct |
|------|------|-------------------|---------|
| `Modules/Blog/resources/views/admin/index.blade.php` | 11 | `route('blog::admin.create')` | `route('admin.posts.create')` |
| `Modules/Blog/resources/views/admin/index.blade.php` | 54 | `route('blog::admin.edit', $post)` | `route('admin.posts.edit', $post)` |
| `Modules/Blog/resources/views/admin/index.blade.php` | 55 | `route('blog::admin.destroy', $post)` | `route('admin.posts.destroy', $post)` |
| `Modules/Blog/resources/views/admin/create.blade.php` | 8 | `route('blog::admin.store')` | `route('admin.posts.store')` |
| `Modules/Blog/resources/views/admin/create.blade.php` | 13 | `route('blog::admin.index')` | `route('admin.posts.index')` |
| `Modules/Blog/resources/views/admin/edit.blade.php` | 8 | `route('blog::admin.update', $post)` | `route('admin.posts.update', $post)` |
| `Modules/Blog/resources/views/admin/edit.blade.php` | 14 | `route('blog::admin.index')` | `route('admin.posts.index')` |

### Faq Module

| File | Line | Current (broken) | Correct |
|------|------|-------------------|---------|
| `Modules/Faq/resources/views/admin/index.blade.php` | 11 | `route('faq::admin.create')` | `route('admin.faqs.create')` |
| `Modules/Faq/resources/views/admin/index.blade.php` | 40 | `route('faq::admin.edit', $faq)` | `route('admin.faqs.edit', $faq)` |
| `Modules/Faq/resources/views/admin/index.blade.php` | 41 | `route('faq::admin.destroy', $faq)` | `route('admin.faqs.destroy', $faq)` |
| `Modules/Faq/resources/views/admin/create.blade.php` | 8 | `route('faq::admin.store')` | `route('admin.faqs.store')` |
| `Modules/Faq/resources/views/admin/create.blade.php` | 13 | `route('faq::admin.index')` | `route('admin.faqs.index')` |
| `Modules/Faq/resources/views/admin/edit.blade.php` | 8 | `route('faq::admin.update', $faq)` | `route('admin.faqs.update', $faq)` |
| `Modules/Faq/resources/views/admin/edit.blade.php` | 14 | `route('faq::admin.index')` | `route('admin.faqs.index')` |

### Testimonial Module

| File | Line | Current (broken) | Correct |
|------|------|-------------------|---------|
| `Modules/Testimonial/resources/views/admin/index.blade.php` | 10 | `route('testimonial::admin.create')` | `route('admin.testimonials.create')` |
| `Modules/Testimonial/resources/views/admin/index.blade.php` | 39 | `route('testimonial::admin.edit', $t)` | `route('admin.testimonials.edit', $t)` |
| `Modules/Testimonial/resources/views/admin/index.blade.php` | 40 | `route('testimonial::admin.destroy', $t)` | `route('admin.testimonials.destroy', $t)` |
| `Modules/Testimonial/resources/views/admin/edit.blade.php` | 8 | `route('testimonial::admin.update', $testimonial)` | `route('admin.testimonials.update', $testimonial)` |
| `Modules/Testimonial/resources/views/admin/edit.blade.php` | 14 | `route('testimonial::admin.index')` | `route('admin.testimonials.index')` |

---

## 2. CRITICAL — Broken View Reference (1 occurrence)

| File | Line | Current (broken) | Correct |
|------|------|-------------------|---------|
| `app/Http/Middleware/CheckMaintenanceMode.php` | 39 | `view('frontend.maintenance', [...])` | `view('core::frontend.maintenance', [...])` |

The maintenance view was moved to `Modules/Core/resources/views/frontend/maintenance.blade.php` but the middleware still references the old path. Will cause `ViewNotFoundException` when maintenance mode is enabled.

---

## 3. WARNING — Hardcoded URLs (3 occurrences)

| File | Line | Current | Recommended |
|------|------|---------|-------------|
| `app/Http/Controllers/Auth/AuthenticatedSessionController.php` | 54 | `return redirect('/');` | `return redirect()->route('home');` |
| `Modules/Core/app/Services/SitemapService.php` | 17–43 | Builds URLs with string concat `$base . '/products/'` | Use `route()` helper for each URL |
| `resources/views/components/frontend/cart-drawer.blade.php` | 48, 63 | `:href="'/products/' + item.product_slug"` | Pass a route pattern via data attribute |

---

## 4. WARNING — Orphaned File (1 occurrence)

| File | Description |
|------|-------------|
| `resources/views/layouts/navigation.blade.php` | Breeze default nav component, not referenced anywhere. The project uses `frontend.partials.navbar` and `admin.layouts.app` instead. Safe to delete. |

---

## 5. WARNING — Unused Import (1 occurrence)

| File | Line | Issue |
|------|------|-------|
| `Modules/Core/app/Http/Controllers/SitemapController.php` | 5 | `use App\Http\Controllers\Controller;` imported but class does not extend `Controller` |

---

## 6. INFO — Orphaned Module Scaffold Files (5 occurrences)

These are default nwidart/laravel-modules layout stubs generated during module creation. They are never used — all modules use the shared layouts in `resources/views/`.

| File |
|------|
| `Modules/Contact/resources/views/components/layouts/master.blade.php` |
| `Modules/Order/resources/views/components/layouts/master.blade.php` |
| `Modules/Shop/resources/views/components/layouts/master.blade.php` |
| `Modules/Payment/resources/views/components/layouts/master.blade.php` |
| `Modules/Core/resources/views/components/layouts/master.blade.php` |

---

## 7. INFO — Prefer `route()` over `url()` (4 occurrences)

| File | Line | Current | Recommended |
|------|------|---------|-------------|
| `resources/views/admin/layouts/app.blade.php` | 101 | `url('/')` | `route('home')` |
| `resources/views/admin/layouts/app.blade.php` | 106 | `url('/locale')` | `route('locale.switch', ...)` |
| `resources/views/frontend/partials/footer.blade.php` | 5 | `url('/')` | `route('home')` |
| `public/js/frontend/cart-drawer.js` | 14–17 | Hardcoded `/cart/items`, `/cart/` | Pass URLs via data attributes from Blade |

---

## 8. INFO — Outdated Documentation (1 occurrence)

| File | Issue |
|------|-------|
| `resources/views/frontend/README.md` | References `frontend/home.blade.php` in `resources/views/`, but home view has moved to `Modules/Core/resources/views/frontend/home.blade.php` |

---

## 9. INFO — Breeze Scaffold Layouts (2 files, kept intentionally)

| File | Used By |
|------|---------|
| `resources/views/layouts/app.blade.php` | Dashboard page via `<x-app-layout>` |
| `resources/views/layouts/guest.blade.php` | Auth pages (login, register) via `<x-guest-layout>` |

These are part of Laravel Breeze and are used by the auth system. No action needed.

---

## 10. INFO — Empty Route File (harmless)

| File | Description |
|------|-------------|
| `Modules/Payment/routes/web.php` | Empty file, loaded by RouteServiceProvider. No customer-facing routes exist. Harmless but could remove `mapWebRoutes()` from Payment's RouteServiceProvider. |

---

## What's Clean

- **Namespaces & imports**: All PHP classes have correct namespace declarations and cross-module imports (after the `AccountService` fix)
- **Controllers**: All properly extend `App\Http\Controllers\Controller` with correct import
- **Old `App\Services\*`**: Zero remaining references — migration is complete
- **`app/Services/`**: Empty as expected
- **`app/Http/Controllers/`**: Only base `Controller.php` + `Auth/` directory
- **Modules status**: All 13 modules enabled
- **Route middleware**: All admin routes have `auth`, `verified`, `is_admin` middleware
- **No duplicate route names** across modules
- **No TODO/FIXME comments** in codebase
- **PSR-4 autoload**: Correct for all modules
- **Migration scripts (.ps1)**: Already cleaned up
