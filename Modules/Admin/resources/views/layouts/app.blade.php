<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
>
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
        {{-- Sidebar overlay (mobile) --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-20 hidden bg-black/50 md:hidden" aria-hidden="true"></div>
        {{-- Sidebar --}}
        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-30 w-64 -translate-x-full transform bg-gray-800 text-white shadow-xl transition-transform duration-200 ease-in-out md:relative md:translate-x-0 md:flex-shrink-0">
            <div class="flex h-16 items-center justify-between border-b border-gray-700 px-4 md:justify-center">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-semibold">{{ config('app.name') }} Admin</a>
                <button type="button" id="sidebar-close" class="rounded-lg p-2 hover:bg-gray-700 md:hidden" aria-label="{{ __('Close menu') }}">
                    <span class="material-icons">close</span>
                </button>
            </div>
            <nav class="space-y-1 overflow-y-auto p-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="material-icons text-lg">dashboard</span> {{ __('Dashboard') }}
                </a>
                <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.settings.edit') || request()->routeIs('admin.settings.update') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="material-icons text-lg">settings</span> {{ __('Settings') }}
                </a>
                <a href="{{ route('admin.translations.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.translations.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="material-icons text-lg">translate</span> {{ __('Translations') }}
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
                <a href="{{ route('admin.page-contents.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.page-contents.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="material-icons text-lg">article</span> {{ __('Page content') }}
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.reviews.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="material-icons text-lg">star</span> {{ __('Reviews') }}
                </a>
                <a href="{{ url('/') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm hover:bg-gray-700" target="_blank">
                    <span class="material-icons text-lg">storefront</span> {{ __('View store') }}
                </a>
            </nav>
        </aside>
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex h-16 flex-shrink-0 items-center justify-between gap-4 border-b border-gray-200 bg-white px-4 md:px-6">
                <div class="flex items-center gap-3">
                    <button type="button" id="sidebar-toggle" class="rounded-lg p-2 text-gray-600 hover:bg-gray-100 md:hidden" aria-label="{{ __('Open menu') }}">
                        <span class="material-icons">menu</span>
                    </button>
                    <h1 class="truncate text-lg font-semibold">@yield('heading', __('Admin'))</h1>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <label for="admin-locale" class="sr-only">{{ __('Language') }}</label>
                        <select id="admin-locale" class="appearance-none rounded-xl border border-gray-200 bg-gray-50 py-2 pl-3 pr-8 text-sm font-medium text-gray-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20" onchange="window.location.href='{{ url('/locale') }}/'+this.value">
                            <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>{{ __('English') }}</option>
                            <option value="ar" {{ app()->getLocale() === 'ar' ? 'selected' : '' }}>{{ __('Arabic') }}</option>
                        </select>
                        <span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-gray-400">
                            <span class="material-icons text-lg">arrow_drop_down</span>
                        </span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-900">{{ __('Logout') }}</button>
                    </form>
                </div>
            </header>
            <main class="min-w-0 flex-1 overflow-auto p-4 md:p-6">
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
    <script>
        (function() {
            var sidebar = document.getElementById('admin-sidebar');
            var overlay = document.getElementById('sidebar-overlay');
            var toggle = document.getElementById('sidebar-toggle');
            var closeBtn = document.getElementById('sidebar-close');
            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            }
            if (toggle) toggle.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (overlay) overlay.addEventListener('click', closeSidebar);
            document.querySelectorAll('#admin-sidebar nav a').forEach(function(a) {
                a.addEventListener('click', function() { if (window.innerWidth < 768) closeSidebar(); });
            });
        })();
    </script>
    @stack('scripts')
    @stack('admin-scripts')
</body>
</html>
