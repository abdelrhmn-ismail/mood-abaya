<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}@isset($header) – {{ $header }}@endisset</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://unpkg.com/@material-tailwind/html@latest/styles/material-tailwind.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js" defer></script>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased" data-ripple-light="true">
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

    @vite(['resources/js/app.js', 'resources/js/frontend.js'])
    @stack('scripts')
</body>
</html>
