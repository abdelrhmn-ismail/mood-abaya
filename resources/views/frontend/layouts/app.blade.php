<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
      class="{{ request()->cookie('theme') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', 'Shop the latest collection')">

    {{-- Tailwind CSS (required for utility classes: flex, grid, bg-*, etc.) --}}
    @vite(['resources/css/app.css'])

    {{-- Material Tailwind component overrides (optional enhancement) --}}
    <link rel="stylesheet" href="https://unpkg.com/@material-tailwind/html@latest/styles/material-tailwind.css" />

    {{-- Material Icons --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    {{-- Ripple effect script --}}
    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js" defer></script>

    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 antialiased" data-ripple-light="true">
    @include('frontend.partials.navbar')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    {{-- Frontend JS (navbar, newsletter) --}}
    @vite(['resources/js/frontend.js'])
    @stack('scripts')
</body>
</html>
