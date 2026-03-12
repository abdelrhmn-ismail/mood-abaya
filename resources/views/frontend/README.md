# Frontend (Material Tailwind)

Public-facing pages using [Material Tailwind HTML](https://www.material-tailwind.com/docs/html/installation).

## Structure

```
frontend/
├── layouts/
│   └── app.blade.php    # Main layout (Material Tailwind CDN, navbar, footer)
├── partials/
│   ├── navbar.blade.php # Sticky navbar + mobile menu
│   └── footer.blade.php # Footer with links and contact
├── home.blade.php       # Home page (hero, categories, products, CTA)
└── README.md            # This file
```

## Adding a new page

1. Create `resources/views/frontend/your-page.blade.php` extending the layout:

   ```blade
   @extends('frontend.layouts.app')
   @section('title', 'Your Page Title')
   @section('content')
       ...
   @endsection
   ```

2. Add a route in `routes/web.php`:

   ```php
   Route::get('/your-page', fn () => view('frontend.your-page'))->name('your-page');
   ```

## JavaScript

Frontend JS lives in `resources/js/frontend/` and is bundled as `resources/js/frontend.js`:

- **navbar.js** – mobile menu toggle
- **newsletter.js** – newsletter form submit
- **index.js** – imports and runs all modules

Build with: `npm run build` or `npm run dev`
