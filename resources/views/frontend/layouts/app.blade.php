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

    {{-- Tailwind CSS (required for utility classes: flex, grid, bg-*, etc.) --}}
    @vite(['resources/css/app.css'])

    {{-- Material Tailwind component overrides (optional enhancement) --}}
    <link rel="stylesheet" href="https://unpkg.com/@material-tailwind/html@latest/styles/material-tailwind.css" />

    {{-- Cairo (Arabic) & Cinzel (English) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Cinzel:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- Material Icons --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    {{-- Ripple effect script --}}
    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js" defer></script>

    @stack('styles')
</head>
<body class="min-h-screen bg-brand-white text-brand-black antialiased {{ app()->getLocale() === 'ar' ? 'font-cairo' : 'font-cinzel' }}" data-ripple-light="true">
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
