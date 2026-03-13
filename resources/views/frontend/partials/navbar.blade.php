<nav class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur" id="main-navbar">
    <div class="container mx-auto flex flex-wrap items-center justify-between px-4 py-3">
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-slate-900">
            <span class="material-icons text-3xl">storefront</span>
            {{ site_label('site_name') }}
        </a>

        <div class="hidden items-center gap-8 md:flex" data-navbar="menu">
            <a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ site_label('nav_home') }}</a>
            <a href="{{ route('categories') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ site_label('nav_categories') }}</a>
            <a href="{{ route('home') }}#products" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ site_label('nav_products') }}</a>
            <a href="{{ route('contact') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ site_label('nav_contact') }}</a>
        </div>

        <div class="hidden items-center gap-3 md:flex">
            {{-- Locale switcher --}}
            <div class="flex items-center gap-1 rounded-xl border border-slate-200 bg-slate-50 p-0.5">
                <a href="{{ route('locale.switch', 'en') }}" class="rounded-lg px-3 py-1.5 text-sm font-medium {{ app()->getLocale() === 'en' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">{{ __('English') }}</a>
                <a href="{{ route('locale.switch', 'ar') }}" class="rounded-lg px-3 py-1.5 text-sm font-medium {{ app()->getLocale() === 'ar' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">{{ __('Arabic') }}</a>
            </div>
            <a href="{{ route('cart') }}" class="flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-200" data-ripple-light="true">
                <span class="material-icons text-xl">shopping_cart</span>
                {{ site_label('nav_cart') }}
                @if(isset($cartCount) && $cartCount > 0)
                    <span class="rounded-full bg-slate-900 px-2 py-0.5 text-xs text-white">{{ $cartCount }}</span>
                @endif
            </a>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="rounded-xl px-4 py-2.5 text-sm font-medium text-indigo-600 hover:bg-indigo-50">{{ site_label('nav_admin') }}</a>
                @endif
                <a href="{{ route('account') }}" class="rounded-xl px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100">{{ site_label('nav_account') }}</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="rounded-xl px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100">{{ site_label('nav_logout') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="rounded-xl px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100">{{ site_label('nav_login') }}</a>
                <a href="{{ route('register') }}" class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">{{ site_label('nav_register') }}</a>
            @endauth
        </div>

        <button type="button" class="rounded-xl p-2 text-slate-600 hover:bg-slate-100 md:hidden" aria-label="Toggle menu" data-navbar="toggle">
            <span class="material-icons" data-navbar="icon-open">menu</span>
            <span class="material-icons hidden" data-navbar="icon-close">close</span>
        </button>
    </div>

    <div class="hidden w-full flex-col gap-1 border-t border-slate-200 bg-white px-4 py-4 md:hidden" data-navbar="mobile-menu">
        <a href="{{ route('home') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ site_label('nav_home') }}</a>
        <a href="{{ route('categories') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ site_label('nav_categories') }}</a>
        <a href="{{ route('home') }}#products" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ site_label('nav_products') }}</a>
        <a href="{{ route('contact') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ site_label('nav_contact') }}</a>
        <div class="flex items-center gap-2 border-b border-slate-100 px-3 py-2">
            <span class="text-sm text-slate-500">{{ __('Language') }}:</span>
            <a href="{{ route('locale.switch', 'en') }}" class="text-sm font-medium {{ app()->getLocale() === 'en' ? 'text-slate-900' : 'text-slate-600' }}">{{ __('English') }}</a>
            <span class="text-slate-300">|</span>
            <a href="{{ route('locale.switch', 'ar') }}" class="text-sm font-medium {{ app()->getLocale() === 'ar' ? 'text-slate-900' : 'text-slate-600' }}">{{ __('Arabic') }}</a>
        </div>
        <a href="{{ route('cart') }}" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">
            <span class="material-icons text-lg">shopping_cart</span>
            {{ site_label('nav_cart') }}
            @if(isset($cartCount) && $cartCount > 0)
                <span class="rounded-full bg-slate-900 px-2 py-0.5 text-xs text-white">{{ $cartCount }}</span>
            @endif
        </a>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-indigo-600 hover:bg-indigo-50">{{ site_label('nav_admin') }}</a>
            @endif
            <a href="{{ route('account') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ site_label('nav_account') }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-lg px-3 py-2.5 text-left text-sm font-medium text-slate-700 hover:bg-slate-100">{{ site_label('nav_logout') }}</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ site_label('nav_login') }}</a>
            <a href="{{ route('register') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ site_label('nav_register') }}</a>
        @endauth
    </div>
</nav>
