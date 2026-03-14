<nav class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur" id="main-navbar">
    <div class="container mx-auto flex flex-wrap items-center justify-between px-4 py-3">
        <a href="{{ route('home') }}" class="flex items-center shrink-0" aria-label="{{ site_label('site_name') }}">
            @if(site_logo_url())
                <img src="{{ site_logo_url() }}" alt="" class="h-9 w-auto max-w-[160px] object-contain md:h-10 md:max-w-[180px]">
            @else
                <span class="material-icons text-3xl text-slate-900">storefront</span>
            @endif
        </a>

        <div class="hidden flex-1 items-center justify-center gap-4 md:flex" data-navbar="menu">
            <div class="flex items-center gap-6 lg:gap-8">
                <a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ site_label('nav_home') }}</a>
                <a href="{{ route('categories') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ site_label('nav_categories') }}</a>
                <a href="{{ route('home') }}#products" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ site_label('nav_products') }}</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ site_label('nav_contact') }}</a>
            </div>
            <form action="{{ route('search') }}" method="GET" class="w-full min-w-0 max-w-[200px] lg:max-w-[240px]" role="search">
                <label for="nav-search" class="sr-only">{{ __('Search products') }}</label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                        <span class="material-icons text-lg">search</span>
                    </span>
                    <input type="search" name="q" id="nav-search" value="{{ request('q') }}" placeholder="{{ __('Search products') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 transition focus:border-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-slate-900/20">
                </div>
            </form>
        </div>

        <div class="hidden items-center gap-3 md:flex">
            {{-- Language dropdown --}}
            <div class="relative" x-data="{ localeOpen: false }" @click.outside="localeOpen = false">
                <button type="button"
                        @click="localeOpen = !localeOpen"
                        class="flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"
                        aria-haspopup="true"
                        :aria-expanded="localeOpen"
                        aria-label="{{ __('Language') }}">
                    <span class="material-icons text-lg">language</span>
                    <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': localeOpen }">expand_more</span>
                </button>
                <div x-show="localeOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 top-full z-50 mt-1 min-w-[120px] rounded-xl border border-slate-200 bg-white py-1 shadow-lg" x-cloak style="display: none;">
                    <a href="{{ route('locale.switch', 'en') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 {{ app()->getLocale() === 'en' ? 'bg-slate-100 font-medium' : '' }}">{{ __('English') }}</a>
                    <a href="{{ route('locale.switch', 'ar') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 {{ app()->getLocale() === 'ar' ? 'bg-slate-100 font-medium' : '' }}">{{ __('Arabic') }}</a>
                </div>
            </div>
            <a href="{{ route('cart') }}" class="flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-200" data-ripple-light="true" aria-label="{{ site_label('nav_cart') }}">
                <span class="material-icons text-xl">shopping_cart</span>
                @if(isset($cartCount) && $cartCount > 0)
                    <span class="rounded-full bg-slate-900 px-2 py-0.5 text-xs text-white">{{ $cartCount }}</span>
                @endif
            </a>
            @auth
                {{-- Account dropdown with username --}}
                <div class="relative" x-data="{ userMenuOpen: false }" @click.outside="userMenuOpen = false">
                    <button type="button"
                            @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100"
                            aria-haspopup="true"
                            :aria-expanded="userMenuOpen">
                        <span class="material-icons text-lg">person</span>
                        <span class="max-w-[9rem] truncate text-left">
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
                         class="absolute right-0 top-full z-50 mt-1 min-w-[160px] rounded-xl border border-slate-200 bg-white py-1 shadow-lg"
                         x-cloak
                         style="display: none;">
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-sm text-indigo-600 hover:bg-indigo-50 font-medium">
                                {{ __('Dashboard panel') }}
                            </a>
                        @else
                            <a href="{{ route('account') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                                {{ site_label('nav_account') }}
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="block w-full px-4 py-2.5 text-left text-sm text-slate-700 hover:bg-slate-50">
                                {{ site_label('nav_logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            @else
                {{-- Login / Register dropdown (icon only for guest) --}}
                <div class="relative" x-data="{ accountOpen: false }" @click.outside="accountOpen = false">
                    <button type="button" @click="accountOpen = !accountOpen" class="flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100" aria-haspopup="true" :aria-expanded="accountOpen" aria-label="{{ site_label('nav_login') }}">
                        <span class="material-icons text-lg">person</span>
                        <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': accountOpen }">expand_more</span>
                    </button>
                    <div x-show="accountOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 top-full z-50 mt-1 min-w-[140px] rounded-xl border border-slate-200 bg-white py-1 shadow-lg" x-cloak style="display: none;">
                        <a href="{{ route('login') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">{{ site_label('nav_login') }}</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2.5 text-sm font-medium text-slate-900 hover:bg-slate-50">{{ site_label('nav_register') }}</a>
                    </div>
                </div>
            @endauth
        </div>

        <button type="button" class="rounded-xl p-2 text-slate-600 hover:bg-slate-100 md:hidden" aria-label="Toggle menu" data-navbar="toggle">
            <span class="material-icons" data-navbar="icon-open">menu</span>
            <span class="material-icons hidden" data-navbar="icon-close">close</span>
        </button>
    </div>

    <div class="hidden w-full flex-col gap-1 border-t border-slate-200 bg-white px-4 py-4 md:hidden" data-navbar="mobile-menu">
        <form action="{{ route('search') }}" method="GET" class="mb-2 w-full" role="search">
            <label for="nav-search-mobile" class="sr-only">{{ __('Search products') }}</label>
            <div class="relative">
                <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <span class="material-icons text-lg">search</span>
                </span>
                <input type="search" name="q" id="nav-search-mobile" value="{{ request('q') }}" placeholder="{{ __('Search products') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 focus:border-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-slate-900/20">
            </div>
        </form>
        <a href="{{ route('home') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ site_label('nav_home') }}</a>
        <a href="{{ route('categories') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ site_label('nav_categories') }}</a>
        <a href="{{ route('home') }}#products" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ site_label('nav_products') }}</a>
        <a href="{{ route('contact') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ site_label('nav_contact') }}</a>
        {{-- Language dropdown (mobile) --}}
        <div class="relative border-b border-slate-100 px-3 py-2" x-data="{ localeOpenMobile: false }" @click.outside="localeOpenMobile = false">
            <button type="button" @click="localeOpenMobile = !localeOpenMobile" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">
                <span>{{ __('Language') }}: {{ app()->getLocale() === 'ar' ? __('Arabic') : __('English') }}</span>
                <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': localeOpenMobile }">expand_more</span>
            </button>
            <div x-show="localeOpenMobile" x-transition class="mt-1 space-y-0.5 pl-2">
                <a href="{{ route('locale.switch', 'en') }}" class="block rounded-lg px-3 py-2 text-sm {{ app()->getLocale() === 'en' ? 'bg-slate-100 font-medium text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">{{ __('English') }}</a>
                <a href="{{ route('locale.switch', 'ar') }}" class="block rounded-lg px-3 py-2 text-sm {{ app()->getLocale() === 'ar' ? 'bg-slate-100 font-medium text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">{{ __('Arabic') }}</a>
            </div>
        </div>
        <a href="{{ route('cart') }}" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">
            <span class="material-icons text-lg">shopping_cart</span>
            {{ site_label('nav_cart') }}
            @if(isset($cartCount) && $cartCount > 0)
                <span class="rounded-full bg-slate-900 px-2 py-0.5 text-xs text-white">{{ $cartCount }}</span>
            @endif
        </a>
        @auth
            {{-- Account dropdown (mobile) with username --}}
            <div class="relative" x-data="{ userMenuOpenMobile: false }" @click.outside="userMenuOpenMobile = false">
                <button type="button"
                        @click="userMenuOpenMobile = !userMenuOpenMobile"
                        class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">
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
                        <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-indigo-600 hover:bg-indigo-50">
                            {{ __('Dashboard panel') }}
                        </a>
                    @else
                        <a href="{{ route('account') }}" class="block rounded-lg px-3 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                            {{ site_label('nav_account') }}
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full rounded-lg px-3 py-2.5 text-left text-sm text-slate-700 hover:bg-slate-50">
                            {{ site_label('nav_logout') }}
                        </button>
                    </form>
                </div>
            </div>
        @else
            {{-- Login / Register dropdown (mobile, icon only) --}}
            <div class="relative" x-data="{ accountOpenMobile: false }" @click.outside="accountOpenMobile = false">
                <button type="button" @click="accountOpenMobile = !accountOpenMobile" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100" aria-label="{{ site_label('nav_login') }}">
                    <span class="material-icons text-lg">person</span>
                    <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': accountOpenMobile }">expand_more</span>
                </button>
                <div x-show="accountOpenMobile" x-transition class="mt-1 space-y-0.5 pl-2">
                    <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2.5 text-sm text-slate-700 hover:bg-slate-50">{{ site_label('nav_login') }}</a>
                    <a href="{{ route('register') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-900 hover:bg-slate-50">{{ site_label('nav_register') }}</a>
                </div>
            </div>
        @endauth
    </div>
</nav>
