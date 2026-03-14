# Plan: Translatable Content & Rich Text Editor

This document outlines how to make **admin-inserted data** (products, categories, etc.) translatable per locale (ar/en) and how to add a **rich text editor** (e.g. CKEditor) for description fields.

---

## 1. Goals

| Goal | Description |
|------|-------------|
| **Translatable content** | Product name/description and Category name/description stored per language (ar, en). Frontend and API use current locale automatically. |
| **Admin UX** | In admin, edit name and description in each language (tabs or locale switcher). |
| **Rich text** | Product and category **description** fields use a WYSIWYG editor (CKEditor or TinyMCE); store HTML and render safely on frontend. |

---

## 2. Translatable Data – Approach

### 2.1 Recommended: Spatie Laravel Translatable

- **Package:** `spatie/laravel-translatable`
- **Storage:** Translatable attributes stored as **JSON** in the same table (e.g. `name` = `{"en":"Product name","ar":"اسم المنتج"}`).
- **Benefits:** No extra tables, simple API, automatic fallback to default locale, works with existing Eloquent.

**Install:**
```bash
composer require spatie/laravel-translatable
```

### 2.2 Models to Make Translatable

| Model    | Translatable attributes | Non-translatable (e.g. slug) |
|----------|--------------------------|-------------------------------|
| **Product**  | `name`, `description` | `slug` (single, for URL), `category_id`, `price`, `image`, `stock`, `active` |
| **Category** | `name`, `description` | `slug` (single, for URL), `image`, `sort_order`, `active` |

**Slug strategy:** Keep one `slug` per record (no per-locale slugs). Generate from the **default locale** name (e.g. `en`) so URLs are stable and SEO-friendly. Example: default locale = `en` → slug from `name['en']`.

### 2.3 Database Changes

Current columns are `string`/`text`. Spatie stores JSON in the same column.

- **MySQL 5.7+:** Change `name` and `description` to `json` (or keep `text` and store JSON string; both work).
- **Migration:** New migration that:
  - Alters `products`: `name` → `json` (nullable during migration if needed), `description` → `json` (nullable).
  - Alters `categories`: same.
  - **Data migration:** For existing rows, convert current `name`/`description` into JSON: `{"en": "current value"}` (or `{"ar": "..."}` if your default was Arabic).

Example migration logic:

```php
// For each product/category:
// $currentName = $row->getRawOriginal('name');
// UPDATE ... SET name = JSON_OBJECT('en', $currentName) WHERE ...
```

---

## 3. Implementation Steps – Translatable

### Phase A: DB & Models

1. **Migration**
   - Create migration `add_translatable_to_products_and_categories`.
   - Alter `products`: change `name` to `json`, `description` to `json`; migrate existing data to `{"en": "existing value"}` (or your default locale).
   - Same for `categories`.
   - Decide default locale in config (e.g. `config('app.fallback_locale')` = `en`).

2. **Models**
   - In `App\Models\Product`: `use HasTranslations;` and `public array $translatable = ['name', 'description'];`.
   - In `App\Models\Category`: same.
   - Ensure `slug` remains a regular attribute; in services, generate slug from `$model->getTranslation('name', config('app.fallback_locale'))` (or first available locale).

3. **Config (optional)**
   - Publish config: `php artisan vendor:publish --tag=translatable`.
   - Set `fallback_locale` and `translation_suffix` if needed.

### Phase B: Admin – Save/Load by Locale

4. **Admin forms (Create/Edit)**
   - **Products:** Add locale tabs or a locale dropdown. For each locale (ar, en):
     - Input: `name[en]`, `name[ar]`.
     - Textarea (or rich text, see below): `description[en]`, `description[ar]`.
   - **Categories:** Same.
   - On submit, build array: `name => ['en' => request('name.en'), 'ar' => request('name.ar')]`, same for `description`.
   - Services: when creating/updating, set translations via `$product->setTranslation('name', 'en', $data['name']['en'])` etc., or assign `$product->name = ['en' => ..., 'ar' => ...]` then `save()`.
   - Slug: in ProductService/CategoryService, generate from default locale name, e.g. `Str::slug($data['name'][config('app.fallback_locale')] ?? $data['name']['en'] ?? '')`.

5. **Validation**
   - Form requests: validate `name.en`, `name.ar` (or `name.*`) and `description.en`, `description.ar` as nullable strings; require at least one locale for name if you want.

### Phase C: Frontend & API

6. **Frontend**
   - No change needed for display: `$product->name` and `$product->description` already return the value for current app locale (set by your existing locale middleware).
   - For product description that will be HTML (rich text): use `{!! $product->description !!}` with sanitization (see below).

7. **Queries (admin list, search)**
   - Admin filters: when searching by name, search in JSON, e.g. `where('name->en', 'like', '%'.$q.'%')->orWhere('name->ar', 'like', '%'.$q.'%')`, or use Spatie’s helpers if provided.
   - Sorting by name: order by `name->en` or current locale.

---

## 4. Rich Text Editor – Approach

### 4.1 Options

| Option | Pros | Cons |
|--------|------|-----|
| **CKEditor 5** | Modern, good UX, CDN or npm | Requires build step for custom builds |
| **TinyMCE** | Mature, Composer package or CDN | Heavier |
| **Quill** | Lightweight, easy to integrate | Fewer features out of the box |
| **Trix (Laravel default)** | Simple, already in some stacks | Limited formatting |

**Recommendation:** **CKEditor 5** (Classic or Balloon) via **CDN** for quick integration, or **TinyMCE** via CDN. Both support Arabic and RTL.

### 4.2 Where to Use

- **Product** create/edit: **description** → rich text (WYSIWYG).
- **Category** create/edit: **description** → rich text (WYSIWYG).

Optional: contact message reply, static pages, etc. (can be added later).

### 4.3 Implementation Steps – Rich Text

1. **Include editor in admin**
   - Add script + styles in admin layout (or a dedicated Blade partial) for CKEditor 5 or TinyMCE.
   - Example (CKEditor 5 CDN): add script tag from CDN, then init on textareas with a class, e.g. `data-rich-editor` or `.rich-editor`.

2. **Blade component or partial**
   - Create `admin::components.rich-editor` (or include) that:
     - Renders a `<textarea>` with `name`, `id`, optional `value` (for edit).
     - Optionally wraps with a label.
   - In the same view or via JS, initialize the editor on that textarea (by id or class).

3. **Forms**
   - Product create/edit: replace plain textarea for `description` with the rich editor component; one textarea per locale (e.g. `description[en]`, `description[ar]`).
   - Category create/edit: same.

4. **Storage**
   - Store HTML as-is in DB (translatable JSON: `description` = `{"en":"<p>...</p>","ar":"<p>...</p>"}`).

5. **Output & security**
   - **Admin:** Show stored HTML in editor when editing (no sanitization needed in admin).
   - **Frontend:** Render with `{!! $product->description !!}` but **sanitize** to prevent XSS. Options:
     - **Laravel only:** Allow a small set of tags via `strip_tags($html, '<p><br><strong><em><ul><ol><li><a><h2><h3>')`.
     - **Package:** `mews/purifier` (HTMLPurifier) for stricter sanitization.
   - Decide allowed tags and add a helper, e.g. `safe_html($product->description)`.

---

## 5. What Must Be Done – Checklist

### Translatable content

- [ ] Install `spatie/laravel-translatable`.
- [ ] Migration: alter `products` and `categories` to store `name` and `description` as JSON; migrate existing data to default locale.
- [ ] Add `HasTranslations` and `$translatable` to `Product` and `Category`.
- [ ] Update `ProductService` / `CategoryService`: slug generation from default-locale name; create/update using translation arrays.
- [ ] Admin product create/edit: form fields per locale for name and description (tabs or grouped fields).
- [ ] Admin category create/edit: same.
- [ ] Form requests: validate `name.en`, `name.ar`, `description.en`, `description.ar`.
- [ ] Admin list/search: query and sort by translated name (e.g. `name->en` or current locale).
- [ ] Frontend: keep using `$product->name`, `$product->description`, `$category->name`, `$category->description` (already locale-aware once model is translatable).

### Rich text editor

- [ ] Choose editor: CKEditor 5 or TinyMCE (recommended: CKEditor 5 via CDN for simplicity).
- [ ] Add editor script + styles to admin layout (or a partial).
- [ ] Create Blade component/partial for rich text textarea (e.g. `admin::components.rich-editor`).
- [ ] Product create/edit: use rich editor for `description[en]` and `description[ar]`.
- [ ] Category create/edit: same.
- [ ] Frontend: render description with `{!! ... !!}` and a safe HTML helper (e.g. `safe_html()` using `strip_tags` or Purifier).

### Optional / Later

- [ ] Add more translatable entities (e.g. static pages, labels in DB).
- [ ] Slug per locale (more complex routing and DB; not in initial scope).
- [ ] Admin UI to set “default locale” per product/category (current plan: one default locale from config).

---

## 6. File / Code Touchpoints

| Area | Files to create or modify |
|------|----------------------------|
| **Migration** | New migration in `database/migrations/` |
| **Models** | `app/Models/Product.php`, `app/Models/Category.php` |
| **Services** | `Modules/Admin/app/Services/ProductService.php`, `CategoryService.php` |
| **Form requests** | `StoreProductRequest`, `UpdateProductRequest`, `StoreCategoryRequest`, `UpdateCategoryRequest` (or inline validation) |
| **Admin views** | Product create/edit, Category create/edit (locale tabs + rich editor) |
| **Admin layout** | Include CKEditor/TinyMCE script + init (or component) |
| **Components** | New: `Modules/Admin/resources/views/components/rich-editor.blade.php` (and optional JS) |
| **Frontend views** | Product and category detail pages: use `{!! safe_html($product->description) !!}` (and similar for category) |
| **Helper** | `app/Helpers/helpers.php`: add `safe_html()` if using strip_tags; or use Purifier in a helper |

---

## 7. Summary

- **Translations:** Use **Spatie Laravel Translatable**; store `name` and `description` as JSON on Product and Category; one slug per record from default locale; admin forms with locale tabs/inputs; frontend stays locale-aware via existing middleware.
- **Rich text:** Add **CKEditor 5** (or TinyMCE) in admin for Product and Category descriptions; store HTML in translatable `description`; on frontend output with a **safe HTML** helper to avoid XSS.

This plan covers what must be done for translatable products/categories and rich text descriptions; you can implement in the order above and extend to other “inserted data” later using the same pattern.
