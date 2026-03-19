<nav class="sticky top-0 z-50 border-b border-slate-200 bg-brand-white/95 shadow-sm backdrop-blur" id="main-navbar">
    <div class="container mx-auto flex flex-wrap items-center justify-between gap-3 px-4 py-3">
        <a href="{{ route('home') }}" class="flex items-center shrink-0" aria-label="{{ site_label('site_name') }}">
            @if(site_logo_url())
                <img src="{{ site_logo_url() }}" alt="" class="h-9 w-auto max-w-[160px] object-contain md:h-10 md:max-w-[180px]">
            @else
                <span class="material-icons text-3xl text-brand-teal">storefront</span>
            @endif
        </a>

        <div class="hidden flex-1 items-center justify-center gap-4 md:flex" data-navbar="menu">
            <div class="flex items-center gap-6 lg:gap-8">
                <a href="{{ route('home') }}" class="text-sm font-medium text-brand-black/80 hover:text-brand-teal">{{ site_label('nav_home') }}</a>
                <a href="{{ route('categories') }}" class="text-sm font-medium text-brand-black/80 hover:text-brand-teal">{{ site_label('nav_categories') }}</a>
                <a href="{{ route('home') }}#products" class="text-sm font-medium text-brand-black/80 hover:text-brand-teal">{{ site_label('nav_products') }}</a>
                <a href="{{ route('about') }}" class="text-sm font-medium text-brand-black/80 hover:text-brand-teal">{{ __('About Us') }}</a>
                <a href="{{ route('blog.index') }}" class="text-sm font-medium text-brand-black/80 hover:text-brand-teal">{{ __('Blog') }}</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium text-brand-black/80 hover:text-brand-teal">{{ site_label('nav_contact') }}</a>
            </div>
            <form action="{{ route('search') }}" method="GET" class="w-full min-w-0 max-w-[200px] lg:max-w-[240px]" role="search">
                <label for="nav-search" class="sr-only">{{ __('Search products') }}</label>
                <div class="relative flex items-center">
                    <span class="pointer-events-none absolute start-3 flex items-center justify-center text-slate-400 inset-y-0">
                        <span class="material-icons text-lg leading-none">search</span>
                    </span>
                    <input type="search" name="q" id="nav-search" value="{{ request('q') }}" placeholder="{{ __('Search products') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2 ps-10 pe-4 text-sm text-brand-black placeholder-slate-400 transition focus:border-brand-teal focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-teal/20">
                </div>
            </form>
        </div>

        <div class="hidden items-center gap-3 md:flex">
            {{-- Language dropdown --}}
            <div class="relative" x-data="{ localeOpen: false }" @click.outside="localeOpen = false">
                <button type="button"
                        @click="localeOpen = !localeOpen"
                        class="flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10"
                        aria-haspopup="true"
                        :aria-expanded="localeOpen"
                        aria-label="{{ __('Language') }}">
                    <span class="material-icons text-lg">language</span>
                    <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': localeOpen }">expand_more</span>
                </button>
                <div x-show="localeOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute end-0 top-full z-50 mt-1 min-w-[140px] rounded-xl border border-slate-200 bg-brand-white py-1 shadow-lg" x-cloak style="display: none;">
                    <a href="{{ route('locale.switch', 'en') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-brand-black/90 hover:bg-brand-gold/10 {{ app()->getLocale() === 'en' ? 'bg-brand-gold/20 font-medium' : '' }}">
                        <span class="fi fi-gb rounded-sm shadow-sm" style="width: 1.25rem; height: 0.875rem; background-size: cover;"></span>
                        {{ __('English') }}
                    </a>
                    <a href="{{ route('locale.switch', 'ar') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-brand-black/90 hover:bg-brand-gold/10 {{ app()->getLocale() === 'ar' ? 'bg-brand-gold/20 font-medium' : '' }}">
                        <span class="fi fi-sa rounded-sm shadow-sm" style="width: 1.25rem; height: 0.875rem; background-size: cover;"></span>
                        {{ __('Arabic') }}
                    </a>
                </div>
            </div>
            <a href="{{ route('account') }}#wishlist" id="nav-wishlist-link" class="flex items-center gap-2 rounded-xl bg-brand-gold/15 px-4 py-2.5 text-sm font-medium text-brand-teal transition hover:bg-brand-gold/25" data-ripple-light="true" aria-label="{{ __('Wishlist') }}">
                <span class="material-icons text-xl">favorite</span>
                <span id="nav-wishlist-count" class="rounded-full bg-brand-teal px-2 py-0.5 text-xs text-white" style="{{ (isset($wishlistCount) && $wishlistCount > 0) ? '' : 'display:none' }}">{{ $wishlistCount ?? 0 }}</span>
            </a>
            <button type="button" id="nav-cart-link" onclick="window.dispatchEvent(new CustomEvent('cart-drawer-open'))" class="flex items-center gap-2 rounded-xl bg-brand-gold/15 px-4 py-2.5 text-sm font-medium text-brand-teal transition hover:bg-brand-gold/25 cursor-pointer" data-ripple-light="true" aria-label="{{ site_label('nav_cart') }}">
                <span class="material-icons text-xl">shopping_cart</span>
                <span id="nav-cart-count" class="rounded-full bg-brand-teal px-2 py-0.5 text-xs text-white" style="{{ (isset($cartCount) && $cartCount > 0) ? '' : 'display:none' }}">{{ $cartCount ?? 0 }}</span>
            </button>
            @auth
                {{-- Account dropdown with username --}}
                <div class="relative" x-data="{ userMenuOpen: false }" @click.outside="userMenuOpen = false">
                    <button type="button"
                            @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10"
                            aria-haspopup="true"
                            :aria-expanded="userMenuOpen">
                        <span class="material-icons text-lg">person</span>
                        <span class="max-w-[9rem] truncate text-start">
                            {{ \Illuminate\Support\Str::limit(auth()->user()->name, 18) }}
                        </span>
                        <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': userMenuOpen }">expand_more</span>
                    </button>
                    <div x-show="userMenuOpen"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute end-0 top-full z-50 mt-1 min-w-[160px] rounded-xl border border-slate-200 bg-brand-white py-1 shadow-lg"
                         x-cloak
                         style="display: none;">
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-sm text-brand-teal hover:bg-brand-gold/10 font-medium">
                                {{ __('Dashboard panel') }}
                            </a>
                            <a href="{{ route('admin.settings.frontend') }}" class="block px-4 py-2.5 text-sm text-brand-teal hover:bg-brand-gold/10 font-medium">
                                {{ __('Frontend settings') }}
                            </a>
                        @else
                            <a href="{{ route('account') }}" class="block px-4 py-2.5 text-sm text-brand-black/90 hover:bg-brand-gold/10">
                                {{ site_label('nav_account') }}
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="block w-full px-4 py-2.5 text-left text-sm text-brand-black/90 hover:bg-brand-gold/10">
                                {{ site_label('nav_logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            @else
                {{-- Login / Register dropdown (icon only for guest) --}}
                <div class="relative" x-data="{ accountOpen: false }" @click.outside="accountOpen = false">
                    <button type="button" @click="accountOpen = !accountOpen" class="flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10" aria-haspopup="true" :aria-expanded="accountOpen" aria-label="{{ site_label('nav_login') }}">
                        <span class="material-icons text-lg">person</span>
                        <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': accountOpen }">expand_more</span>
                    </button>
                    <div x-show="accountOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute end-0 top-full z-50 mt-1 min-w-[140px] rounded-xl border border-slate-200 bg-brand-white py-1 shadow-lg" x-cloak style="display: none;">
                        <a href="{{ route('login') }}" class="block px-4 py-2.5 text-sm text-brand-black/90 hover:bg-brand-gold/10">{{ site_label('nav_login') }}</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2.5 text-sm font-medium text-brand-teal hover:bg-brand-gold/10">{{ site_label('nav_register') }}</a>
                    </div>
                </div>
            @endauth
        </div>

        <button type="button" class="rounded-xl p-2 text-brand-teal hover:bg-brand-gold/10 md:hidden" aria-label="Toggle menu" data-navbar="toggle">
            <span class="material-icons" data-navbar="icon-open">menu</span>
            <span class="material-icons hidden" data-navbar="icon-close">close</span>
        </button>
    </div>

    <div class="hidden w-full flex-col gap-1 border-t border-slate-200 bg-brand-white px-4 py-4 md:hidden" data-navbar="mobile-menu">
        <form action="{{ route('search') }}" method="GET" class="mb-2 w-full" role="search">
            <label for="nav-search-mobile" class="sr-only">{{ __('Search products') }}</label>
<div class="relative flex items-center">
                <span class="pointer-events-none absolute start-3 flex items-center justify-center text-slate-400 inset-y-0">
                        <span class="material-icons text-lg leading-none">search</span>
                    </span>
                    <input type="search" name="q" id="nav-search-mobile" value="{{ request('q') }}" placeholder="{{ __('Search products') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 ps-10 pe-4 text-sm text-brand-black placeholder-slate-400 focus:border-brand-teal focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-teal/20">
            </div>
        </form>
        <a href="{{ route('home') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10">{{ site_label('nav_home') }}</a>
        <a href="{{ route('categories') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10">{{ site_label('nav_categories') }}</a>
        <a href="{{ route('home') }}#products" class="rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10">{{ site_label('nav_products') }}</a>
        <a href="{{ route('about') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10">{{ __('About Us') }}</a>
        <a href="{{ route('blog.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10">{{ __('Blog') }}</a>
        <a href="{{ route('contact') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10">{{ site_label('nav_contact') }}</a>
        {{-- Language dropdown (mobile) --}}
        <div class="relative border-b border-slate-100 px-3 py-2" x-data="{ localeOpenMobile: false }" @click.outside="localeOpenMobile = false">
            <button type="button" @click="localeOpenMobile = !localeOpenMobile" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10">
                <span>{{ __('Language') }}: {{ app()->getLocale() === 'ar' ? __('Arabic') : __('English') }}</span>
                <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': localeOpenMobile }">expand_more</span>
            </button>
            <div x-show="localeOpenMobile" x-transition class="mt-1 space-y-0.5 ps-2">
                <a href="{{ route('locale.switch', 'en') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ app()->getLocale() === 'en' ? 'bg-brand-gold/20 font-medium text-brand-teal' : 'text-brand-black/80 hover:bg-brand-gold/10' }}">
                    <span class="fi fi-gb rounded-sm shadow-sm" style="width: 1.125rem; height: 0.75rem; background-size: cover;"></span>
                    {{ __('English') }}
                </a>
                <a href="{{ route('locale.switch', 'ar') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ app()->getLocale() === 'ar' ? 'bg-brand-gold/20 font-medium text-brand-teal' : 'text-brand-black/80 hover:bg-brand-gold/10' }}">
                    <span class="fi fi-sa rounded-sm shadow-sm" style="width: 1.125rem; height: 0.75rem; background-size: cover;"></span>
                    {{ __('Arabic') }}
                </a>
            </div>
        </div>
        <a href="{{ route('account') }}#wishlist" id="nav-wishlist-link-mobile" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-brand-teal hover:bg-brand-gold/10">
            <span class="material-icons text-lg">favorite</span>
            {{ __('Wishlist') }}
            <span id="nav-wishlist-count-mobile" class="rounded-full bg-brand-teal px-2 py-0.5 text-xs text-white" style="{{ (isset($wishlistCount) && $wishlistCount > 0) ? '' : 'display:none' }}">{{ $wishlistCount ?? 0 }}</span>
        </a>
        <button type="button" id="nav-cart-link-mobile" onclick="window.dispatchEvent(new CustomEvent('cart-drawer-open'))" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-brand-teal hover:bg-brand-gold/10 cursor-pointer">
            <span class="material-icons text-lg">shopping_cart</span>
            {{ site_label('nav_cart') }}
            <span id="nav-cart-count-mobile" class="rounded-full bg-brand-teal px-2 py-0.5 text-xs text-white" style="{{ (isset($cartCount) && $cartCount > 0) ? '' : 'display:none' }}">{{ $cartCount ?? 0 }}</span>
        </button>
        @auth
            {{-- Account dropdown (mobile) with username --}}
            <div class="relative" x-data="{ userMenuOpenMobile: false }" @click.outside="userMenuOpenMobile = false">
                <button type="button"
                        @click="userMenuOpenMobile = !userMenuOpenMobile"
                        class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10">
                    <span class="flex items-center gap-2">
                        <span class="material-icons text-lg">person</span>
                        <span class="max-w-[9rem] truncate">
                            {{ \Illuminate\Support\Str::limit(auth()->user()->name, 18) }}
                        </span>
                    </span>
                    <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': userMenuOpenMobile }">expand_more</span>
                </button>
                <div x-show="userMenuOpenMobile" x-transition class="mt-1 space-y-0.5 pl-2">
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-brand-teal hover:bg-brand-gold/10">
                            {{ __('Dashboard panel') }}
                        </a>
                        <a href="{{ route('admin.settings.frontend') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-brand-teal hover:bg-brand-gold/10">
                            {{ __('Frontend settings') }}
                        </a>
                    @else
                        <a href="{{ route('account') }}" class="block rounded-lg px-3 py-2.5 text-sm text-brand-black/90 hover:bg-brand-gold/10">
                            {{ site_label('nav_account') }}
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full rounded-lg px-3 py-2.5 text-left text-sm text-brand-black/90 hover:bg-brand-gold/10">
                            {{ site_label('nav_logout') }}
                        </button>
                    </form>
                </div>
            </div>
        @else
            {{-- Login / Register dropdown (mobile, icon only) --}}
            <div class="relative" x-data="{ accountOpenMobile: false }" @click.outside="accountOpenMobile = false">
                <button type="button" @click="accountOpenMobile = !accountOpenMobile" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10" aria-label="{{ site_label('nav_login') }}">
                    <span class="material-icons text-lg">person</span>
                    <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': accountOpenMobile }">expand_more</span>
                </button>
                <div x-show="accountOpenMobile" x-transition class="mt-1 space-y-0.5 pl-2">
                    <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2.5 text-sm text-brand-black/90 hover:bg-brand-gold/10">{{ site_label('nav_login') }}</a>
                    <a href="{{ route('register') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-brand-teal hover:bg-brand-gold/10">{{ site_label('nav_register') }}</a>
                </div>
            </div>
        @endauth
    </div>
</nav>
