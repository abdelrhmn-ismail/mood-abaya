<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}@isset($header) – {{ $header }}@endisset</title>
    {{-- Core CSS --}}
    <link rel="stylesheet" href="{{ asset('css/core/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/core/brand.css') }}">
    @if(app()->getLocale() === 'ar')
    <link rel="stylesheet" href="{{ asset('css/core/rtl.css') }}">
    @endif
    {{-- Frontend CSS --}}
    <link rel="stylesheet" href="{{ asset('css/frontend/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/components.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Cinzel:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/@material-tailwind/html@latest/styles/material-tailwind.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js" defer></script>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased {{ app()->getLocale() === 'ar' ? 'font-cairo' : 'font-cinzel' }}" data-ripple-light="true">
    @include('frontend.partials.navbar')

    <main class="flex-1 py-12 md:py-16">
        <div class="container mx-auto px-4">
            @isset($header)
                <h1 class="mb-8 text-2xl font-bold text-slate-900 md:text-3xl">{{ $header }}</h1>
            @endisset
            {{ $slot }}
        </div>
    </main>

    @include('frontend.partials.footer')

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
    <script defer src="{{ asset('js/frontend/navbar.js') }}"></script>
    <script defer src="{{ asset('js/frontend/hero-slider.js') }}"></script>
    <script defer src="{{ asset('js/frontend/newsletter.js') }}"></script>
    <script defer src="{{ asset('js/frontend/cookie-consent.js') }}"></script>
    <script defer src="{{ asset('js/frontend/cart-wishlist.js') }}"></script>
    @stack('scripts')
</body>
</html>
