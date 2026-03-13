<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
      class="{{ request()->cookie('theme') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Admin')) - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 antialiased">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 flex-shrink-0 bg-gray-800 text-white">
            <div class="flex h-16 items-center justify-center border-b border-gray-700">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-semibold">{{ config('app.name') }} Admin</a>
            </div>
            <nav class="space-y-1 p-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="material-icons text-lg">dashboard</span> {{ __('Dashboard') }}
                </a>
                <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="material-icons text-lg">settings</span> {{ __('Settings') }}
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="material-icons text-lg">receipt_long</span> {{ __('Orders') }}
                </a>
                <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.payments.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="material-icons text-lg">payment</span> {{ __('Payments') }}
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="material-icons text-lg">inventory_2</span> {{ __('Products') }}
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="material-icons text-lg">category</span> {{ __('Categories') }}
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.contacts.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="material-icons text-lg">mail</span> {{ __('Contact messages') }}
                </a>
                <a href="{{ url('/') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm hover:bg-gray-700" target="_blank">
                    <span class="material-icons text-lg">storefront</span> {{ __('View store') }}
                </a>
            </nav>
        </aside>
        <div class="flex flex-1 flex-col">
            <header class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-6">
                <h1 class="text-lg font-semibold">@yield('heading', __('Admin'))</h1>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Logout') }}</button>
                </form>
            </header>
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-800">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
