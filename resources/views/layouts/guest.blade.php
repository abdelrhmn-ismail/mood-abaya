<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://unpkg.com/@material-tailwind/html@latest/styles/material-tailwind.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js" defer></script>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased" data-ripple-light="true">
    @include('frontend.partials.navbar')

    <main class="min-h-[60vh] py-16 md:py-20">
        <div class="container mx-auto max-w-md px-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                {{ $slot }}
            </div>
        </div>
    </main>

    @include('frontend.partials.footer')

    @vite(['resources/js/frontend.js'])
    @stack('scripts')
</body>
</html>
