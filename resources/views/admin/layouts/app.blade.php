<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(site_favicon_url())
    <link rel="icon" href="{{ site_favicon_url() }}">
    @endif
    <title>@yield('title', __('Admin')) - {{ site_title() }}</title>
    {{-- Cairo (Arabic) & Cinzel (English) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Cinzel:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- Core CSS --}}
    <link rel="stylesheet" href="{{ asset('css/core/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/core/brand.css') }}">
    @if(app()->getLocale() === 'ar')
    <link rel="stylesheet" href="{{ asset('css/core/rtl.css') }}">
    @endif
    {{-- Admin CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
    {{-- Color design system overrides from admin settings --}}
    @include('components.color-overrides')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-100 text-brand-black antialiased {{ app()->getLocale() === 'ar' ? 'font-cairo' : 'font-cinzel' }}">
    <div class="flex min-h-screen">
        {{-- Sidebar overlay (mobile) --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-20 hidden bg-black/50 md:hidden" aria-hidden="true"></div>
        {{-- Sidebar --}}
        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-30 w-64 max-w-[85vw] -translate-x-full transform bg-brand-teal text-white shadow-xl transition-transform duration-200 ease-in-out md:relative md:max-w-none md:translate-x-0 md:flex-shrink-0">
            <div class="flex h-14 items-center justify-center border-b border-brand-teal-dark px-3 sm:h-16 sm:px-4">
                <a href="{{ route('admin.dashboard') }}" class="truncate text-center text-base font-semibold sm:text-lg md:text-xl">{{ site_title() }} Admin</a>
            </div>
            <nav class="max-h-[calc(100vh-3.5rem)] space-y-1 overflow-y-auto overscroll-contain p-3 sm:max-h-[calc(100vh-4rem)] sm:p-4 md:max-h-none">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">dashboard</span> {{ __('Dashboard') }}
                </a>
                <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.settings.edit') || request()->routeIs('admin.settings.update') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">settings</span> {{ __('Settings') }}
                </a>
                <a href="{{ route('admin.settings.frontend') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.settings.frontend*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">palette</span> {{ __('Frontend settings') }}
                </a>
                <a href="{{ route('admin.translations.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.translations.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">translate</span> {{ __('Translations') }}
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.orders.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">receipt_long</span> {{ __('Orders') }}
                </a>
                <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.payments.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">payment</span> {{ __('Payments') }}
                </a>
                <a href="{{ route('admin.payment-methods.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.payment-methods.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">account_balance</span> {{ __('Payment methods') }}
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.products.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">inventory_2</span> {{ __('Products') }}
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.categories.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">category</span> {{ __('Categories') }}
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.users.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">people</span> {{ __('Users') }}
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.contacts.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">mail</span> {{ __('Contact messages') }}
                </a>
                <a href="{{ route('admin.newsletter.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.newsletter.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">subscriptions</span> {{ __('Newsletter subscribers') }}
                </a>
                <a href="{{ route('admin.faqs.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.faqs.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">help_outline</span> {{ __('FAQ') }}
                </a>
                <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.posts.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">newspaper</span> {{ __('Blog / News') }}
                </a>
                <a href="{{ route('admin.testimonials.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.testimonials.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">format_quote</span> {{ __('Testimonials') }}
                </a>
                <a href="{{ route('admin.page-contents.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.page-contents.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">article</span> {{ __('Page content') }}
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.reviews.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20' }}">
                    <span class="material-icons text-lg">star</span> {{ __('Reviews') }}
                </a>
            </nav>
        </aside>
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex min-h-14 flex-shrink-0 flex-wrap items-center justify-between gap-2 border-b border-slate-200 bg-brand-white px-3 py-2 sm:min-h-16 sm:gap-3 sm:px-4 md:flex-nowrap md:px-6 md:py-0">
                <div class="flex min-w-0 flex-1 items-center gap-2 sm:gap-3 md:min-w-0 md:flex-none">
                    <button type="button" id="sidebar-toggle" class="relative inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg p-0 text-brand-teal hover:bg-brand-gold/10 md:hidden" aria-expanded="false" aria-controls="admin-sidebar" aria-label="{{ __('Open menu') }}" data-label-open="{{ __('Open menu') }}" data-label-close="{{ __('Close menu') }}">
                        <span class="material-icons absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-2xl leading-none" data-sidebar-icon-open>menu</span>
                        <span class="material-icons absolute left-1/2 top-1/2 hidden -translate-x-1/2 -translate-y-1/2 text-2xl leading-none" data-sidebar-icon-close>close</span>
                    </button>
                    @if(!$__env->hasSection('heading') || trim((string) $__env->yieldContent('heading')) !== '')
                        <h1 class="min-w-0 truncate text-base font-semibold text-brand-black sm:text-lg">@yield('heading', __('Admin'))</h1>
                    @endif
                </div>
                <div class="flex w-full flex-wrap items-center justify-end gap-2 sm:w-auto sm:gap-3">
                    <a href="{{ url('/') }}" title="{{ __('View store') }}" class="inline-flex items-center gap-1 rounded-xl border border-slate-200 bg-slate-50 px-2 py-1.5 text-xs font-medium text-brand-black transition hover:bg-brand-gold/10 hover:text-brand-teal sm:gap-1.5 sm:px-3 sm:py-2 sm:text-sm" target="_blank" rel="noopener noreferrer">
                        <span class="material-icons text-base sm:text-lg">storefront</span>
                        <span class="hidden sm:inline">{{ __('View store') }}</span>
                    </a>
                    <div class="relative">
                        <label for="admin-locale" class="sr-only">{{ __('Language') }}</label>
                        <select id="admin-locale" class="appearance-none rounded-xl border border-slate-200 bg-slate-50 py-1.5 text-xs font-medium text-brand-black focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20 sm:py-2 sm:text-sm {{ app()->getLocale() === 'ar' ? 'pl-7 pr-2 sm:pl-8 sm:pr-3' : 'pl-2 pr-7 sm:pl-3 sm:pr-8' }}" onchange="window.location.href='{{ url('/locale') }}/'+this.value">
                            <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>{{ __('English') }}</option>
                            <option value="ar" {{ app()->getLocale() === 'ar' ? 'selected' : '' }}>{{ __('Arabic') }}</option>
                        </select>
                        <span class="pointer-events-none absolute top-1/2 -translate-y-1/2 text-slate-400 {{ app()->getLocale() === 'ar' ? 'left-1.5 sm:left-2' : 'right-1.5 sm:right-2' }}">
                            <span class="material-icons text-base sm:text-lg">arrow_drop_down</span>
                        </span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="rounded-xl border border-slate-200 bg-slate-50 px-2 py-1.5 text-xs font-medium text-brand-black transition hover:bg-brand-gold/10 hover:text-brand-teal sm:px-3 sm:py-2 sm:text-sm">{{ __('Logout') }}</button>
                    </form>
                </div>
            </header>
            <main class="min-w-0 flex-1 overflow-auto p-3 sm:p-4 md:p-6">
                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800" role="alert">{{ __(session('success')) }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-800" role="alert">{{ __(session('error')) }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    {{-- Admin JS --}}
    <script defer src="{{ asset('js/admin/sidebar.js') }}"></script>
    <script defer src="{{ asset('js/admin/delete-confirm.js') }}"></script>
    @stack('scripts')
    @stack('admin-scripts')
</body>
</html>
