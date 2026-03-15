<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Maintenance') }} – {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
    <style>
        body { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">
    <div class="mx-auto max-w-lg px-6 py-16 text-center">
        <span class="material-icons text-7xl text-brand-teal">build</span>
        <h1 class="mt-6 text-2xl font-bold text-slate-900 md:text-3xl">{{ __('We\'ll be back soon') }}</h1>
        <p class="mt-4 text-slate-600">
            {{ __('We are performing scheduled maintenance. Thank you for your patience.') }}
        </p>
        @if(!empty($coming_back_at))
            <p class="mt-4 rounded-xl bg-brand-teal/10 px-4 py-3 font-medium text-brand-teal">
                {{ __('Coming back at') }} {{ $coming_back_at }}
            </p>
        @endif
        <p class="mt-8 text-sm text-slate-500">{{ config('app.name') }}</p>
    </div>
</body>
</html>
