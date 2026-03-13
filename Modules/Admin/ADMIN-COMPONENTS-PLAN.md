# Admin Panel – Reusable Components Plan

## Goal
Use shared Blade components across all admin pages so the UI is consistent and easy to maintain. Every list page uses the same **table component** with a modern layout and a dedicated **Actions** column (View / Edit / Delete).

---

## 1. Table Component (`components/table.blade.php`)

**Purpose:** Single reusable data table with configurable columns and an action column.

**Props (passed when including):**
- `$columns` – array of column definitions (see below)
- `$rows` – collection of models
- `$emptyMessage` – string when there are no rows
- `$actions` – optional config for the action column (view / edit / delete)
- `$pagination` – optional paginator for links below the table

**Column definition (each item in `$columns`):**
- `label` – header text (translatable)
- `key` – attribute or dot path, e.g. `name`, `user.name`, `category.name`
- `format` – optional: `datetime`, `price`, `boolean`
- `key2`` – optional second attribute; value becomes `key + glue + key2`
- `glue` – optional (default `' / '`), used when `key2` is set
- `class` – optional CSS class for the `<td>` (e.g. font-mono)

**Actions config (`$actions`):**
- `view_route` – route name for “View” (e.g. `admin.orders.show`). Model is passed as parameter.
- `edit_route` – route name for “Edit” (e.g. `admin.products.edit`)
- `delete_route` – route name for “Delete” (e.g. `admin.products.destroy`)
- `delete_confirm` – confirm message before DELETE

At least one of `view_route`, `edit_route`, or `delete_route` should be set. The component renders an “Actions” column with the corresponding links/button.

**Styling:** Modern table: rounded container, clear thead, striped or hover rows, action column with icon or text links (Edit + Delete, or View only where appropriate).

---

## 2. Where the Table Component Is Used

| Page              | Route                     | Actions column          |
|-------------------|---------------------------|--------------------------|
| Orders            | `admin.orders.index`      | View                    |
| Products          | `admin.products.index`    | Edit, Delete            |
| Categories        | `admin.categories.index`  | Edit, Delete            |
| Payments          | `admin.payments.index`    | View                    |
| Contact messages  | `admin.contacts.index`    | View                    |

All of these list pages should use the same table component and pass their own `$columns`, `$rows`, `$emptyMessage`, `$actions`, and optional `$pagination`.

---

## 3. Optional Future Components (not required for this task)

- **Card** – wrapper for table or form sections (e.g. `components/card.blade.php`)
- **Filter bar** – optional shared filter form (search + selects + “Filter” button)
- **Page header** – title + “Add …” button

These can be added later; the table component is the main building block for list pages.

---

## 4. File Layout

```
Modules/Admin/resources/views/
├── components/
│   └── table.blade.php    ← reusable table with action column
├── orders/
│   └── index.blade.php    ← @include table component
├── products/
│   └── index.blade.php    ← @include table component
├── categories/
│   └── index.blade.php    ← @include table component
├── payments/
│   └── index.blade.php    ← @include table component
└── contacts/
    └── index.blade.php    ← @include table component
```

---

## 5. Usage Example (Products)

```php
// In controller: pass to view as usual (products, categories for filter, etc.)
```

```blade
@include('admin::components.table', [
    'columns' => [
        ['label' => __('Name'), 'key' => 'name'],
        ['label' => __('Category'), 'key' => 'category.name'],
        ['label' => __('Price'), 'key' => 'price', 'format' => 'price'],
        ['label' => __('Stock'), 'key' => 'stock'],
        ['label' => __('Active'), 'key' => 'active', 'format' => 'boolean'],
    ],
    'rows' => $products,
    'emptyMessage' => __('No products yet.'),
    'actions' => [
        'edit_route' => 'admin.products.edit',
        'delete_route' => 'admin.products.destroy',
        'delete_confirm' => __('Delete this product?'),
    ],
    'pagination' => $products,
])
```

This keeps all list pages consistent and makes it easy to add new list pages or change the table design in one place.
