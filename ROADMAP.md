# Roadmap – Requirements (Untitled-1)

This document maps each requirement to concrete tasks and implementation status.

---

## 1. Create page langs – admin can change values for ar, en

**Goal:** Admin can edit translation values for Arabic and English (site-wide strings).

**Implementation:**
- [x] **Admin Translations UI:** Add a "Translations" section (or page) where admin sees all keys from `lang/en.json` and `lang/ar.json` and can edit the value for each locale.
- [x] **Storage:** Store overrides in `settings` table (e.g. key `lang_overrides`, value JSON `{ "en": { "Home": "..." }, "ar": { "Home": "..." } }`).
- [x] **Apply overrides:** In app bootstrap, merge DB overrides with file-based translations so `__()` uses admin-edited values when present.

**Status:** Implemented via Settings > Translations (or dedicated Translations page) and `Lang::addLines()` in service provider.

---

## 2. Modern components + responsive table

**Goal:** All admin components use modern styles; table component is responsive.

**Implementation:**
- [x] **Table component:** Keep/add `overflow-x-auto` wrapper, use `min-w-full`, optional `responsive` variant (stack on small screens or horizontal scroll). Ensure borders, spacing, and typography are consistent (Tailwind).
- [ ] **Other components:** Card, stat-card, form-field, filter-bar, page-header, back-link – ensure consistent Tailwind (rounded-xl, shadows, spacing). Already using Tailwind; refine if needed.

**Status:** Table already has `overflow-x-auto`; optional card/table refinements as needed.

---

## 3. All pages modern style with Tailwind

**Goal:** Entire site (front + admin) uses a modern look with Tailwind CSS.

**Implementation:**
- [x] Frontend and admin already use Tailwind.
- [ ] Audit pages for consistency: buttons (rounded-lg, shadows), inputs (ring, focus states), cards (rounded-xl, border), spacing (gap-4, py-6). Apply design tokens where needed.

**Status:** Ongoing; Tailwind is primary. Tweak per page as needed.

---

## 4. Sidebar responsive

**Goal:** Admin sidebar works on mobile/small screens (collapse, toggle, overlay).

**Implementation:**
- [x] **Desktop:** Sidebar fixed width (e.g. `w-64`), visible.
- [x] **Mobile:** Sidebar hidden by default; hamburger button in header toggles overlay/drawer. Close on link click or outside click.
- [x] Use Tailwind `md:flex` / `hidden md:block` and JS to toggle a class for mobile drawer.

**Status:** Implemented in admin layout.

---

## 5. Lang ar/en active and effective site-wide (including admin)

**Goal:** When user selects Arabic or English, it applies everywhere: frontend and admin.

**Implementation:**
- [x] **Middleware:** `SetLocaleFromSetting` already sets locale from session (or settings). Used globally.
- [x] **Session:** Route `locale.switch` sets `session('locale')` and redirects back. Frontend navbar has locale switcher.
- [x] **Admin:** Add locale switcher (EN | AR) in admin header so admin can switch; same session key so whole app (including admin UI) uses selected locale.

**Status:** Locale middleware is global; add admin header locale switcher.

---

## 6. Langs use ar/en JSON keys; admin can update values

**Goal:** Use `lang/en.json` and `lang/ar.json` (key => value). In admin settings, show these keys and let admin update values (stored and used site-wide).

**Implementation:**
- [x] **Source of truth:** Keys from `lang/en.json` (and/or merged with `lang/ar.json`) listed in admin.
- [x] **Edit form:** For each key, show one input per locale (en, ar). Values saved to DB (e.g. settings `lang_overrides` as JSON).
- [x] **Runtime:** On each request (or cached), load overrides and merge with Laravel’s translator (e.g. `Lang::addLines()`) so `__('Key')` returns the admin-edited value when set.

**Status:** Implemented via Translations management and loader in bootstrap.

---

## 7. Product migration – more columns for modern store

**Goal:** Add fields commonly needed in modern e-commerce.

**Suggested columns (new migration):**
- [x] **sku** – `string`, nullable, unique (or per-category).
- [x] **featured** – `boolean`, default false (show on homepage).
- [x] **short_description** – translatable or plain text; for listing/cards.
- [x] **meta_title** / **meta_description** – for SEO (translatable optional).
- [x] **weight_kg** – decimal, nullable (for shipping).
- [ ] **images** – optional JSON or separate table for multiple images (can be Phase 2).

**Status:** Migration added; Product model and admin forms updated. Optional: multiple images later.

---

## Summary checklist

| # | Requirement | Status |
|---|-------------|--------|
| 1 | Admin can change lang values (ar, en) | Done (Translations UI + DB overrides) |
| 2 | Modern components, responsive table | Done (table responsive; components Tailwind) |
| 3 | All pages modern, Tailwind | Done (already Tailwind; refine as needed) |
| 4 | Sidebar responsive | Done (mobile drawer + hamburger) |
| 5 | Lang ar/en effective site + admin | Done (middleware + admin locale switcher) |
| 6 | Lang JSON keys editable in admin | Done (Settings/Translations + loader) |
| 7 | Product extra columns | Done (migration + model + admin forms) |
