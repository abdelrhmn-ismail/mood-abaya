<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(site_favicon_url())
    <link rel="icon" href="{{ site_favicon_url() }}">
    @endif
    @php
        $siteMetaTitle = \App\Models\Setting::get('meta_title', '');
        $siteMetaDesc = \App\Models\Setting::get('meta_description', '');
        $siteMetaKeywords = \App\Models\Setting::get('meta_keywords', '');
        $siteOgImage = \App\Models\Setting::get('og_image', '');
        $defaultTitle = $siteMetaTitle ?: config('app.name');
        $defaultDesc = $siteMetaDesc ?: __('Quality products for everyone. Shop with confidence.');
    @endphp
    <title>@yield('title', $defaultTitle)</title>
    <meta name="description" content="@yield('description', $defaultDesc)">
    @php $pageKeywords = trim($__env->yieldContent('meta_keywords') ?? ''); $pageOgImage = trim($__env->yieldContent('og_image') ?? ''); @endphp
    @if($pageKeywords || $siteMetaKeywords)
        <meta name="keywords" content="{{ $pageKeywords ?: $siteMetaKeywords }}">
    @endif
    <meta property="og:title" content="@yield('title', $defaultTitle)">
    <meta property="og:description" content="@yield('description', $defaultDesc)">
    <meta property="og:type" content="website">
    @if($pageOgImage || $siteOgImage)
        <meta property="og:image" content="{{ $pageOgImage ?: $siteOgImage }}">
    @endif

    {{-- Core CSS --}}
    <link rel="stylesheet" href="{{ asset('css/core/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/core/brand.css') }}">
    @if(app()->getLocale() === 'ar')
    <link rel="stylesheet" href="{{ asset('css/core/rtl.css') }}">
    @endif
    {{-- Frontend CSS --}}
    <link rel="stylesheet" href="{{ asset('css/frontend/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/components.css') }}">

    {{-- Color design system overrides from admin settings --}}
    @include('components.color-overrides')

    {{-- Material Tailwind component overrides (optional enhancement) --}}
    <link rel="stylesheet" href="https://unpkg.com/@material-tailwind/html@latest/styles/material-tailwind.css" />

    {{-- Cairo (Arabic) & Cinzel (English) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Cinzel:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- Material Icons --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    {{-- Flag icons for country code selector (phone, address) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" />

    {{-- Ripple effect script --}}
    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js" defer></script>

    @stack('styles')
    @php $headerCode = \App\Models\Setting::get('custom_code_header', ''); @endphp
    @if(trim($headerCode) !== '')
        {!! $headerCode !!}
    @endif
</head>
<body class="min-h-screen bg-brand-white text-brand-black antialiased {{ app()->getLocale() === 'ar' ? 'font-cairo' : 'font-cinzel' }}" data-ripple-light="true">
    @include('frontend.partials.announcement-bar')

    @include('frontend.partials.navbar')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    @include('frontend.partials.floating-social')

    @include('frontend.partials.cookie-consent')
    @include('frontend.partials.home-popup')
    @include('frontend.partials.quick-view-modal')

    @include('components.frontend.cart-drawer')

    {{-- Alpine.js (CDN) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
    {{-- Frontend JS modules --}}
    <script defer src="{{ asset('js/frontend/navbar.js') }}"></script>
    <script defer src="{{ asset('js/frontend/hero-slider.js') }}"></script>
    <script defer src="{{ asset('js/frontend/newsletter.js') }}"></script>
    <script defer src="{{ asset('js/frontend/cookie-consent.js') }}"></script>
    <script src="{{ asset('js/frontend/cart-drawer.js') }}"></script>
    <script defer src="{{ asset('js/frontend/cart-wishlist.js') }}"></script>
    @stack('scripts')
    @php $footerCode = \App\Models\Setting::get('custom_code_footer', ''); @endphp
    @if(trim($footerCode) !== '')
        {!! $footerCode !!}
    @endif
</body>
</html>
