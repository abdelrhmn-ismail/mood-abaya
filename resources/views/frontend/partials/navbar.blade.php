<nav class="navbar sticky top-0 z-50 flex flex-wrap items-center justify-between bg-white py-2 text-gray-800 shadow-md"
     id="main-navbar">
    <div class="container mx-auto flex flex-wrap items-center justify-between px-4">
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-gray-900">
            <span class="material-icons text-3xl">storefront</span>
            {{ config('app.name') }}
        </a>

        <div class="hidden items-center gap-6 md:flex" data-navbar="menu">
            <a href="{{ route('home') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">{{ __('Home') }}</a>
            <a href="{{ route('categories') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">{{ __('Categories') }}</a>
            <a href="{{ route('home') }}#products" class="text-sm font-medium text-gray-700 hover:text-gray-900">{{ __('Products') }}</a>
            <a href="{{ route('contact') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">{{ __('Contact') }}</a>
        </div>

        <div class="hidden items-center gap-2 md:flex">
            <button type="button" class="theme-toggle middle none center rounded-lg p-2 font-sans text-xs font-bold uppercase text-gray-600 hover:bg-gray-100 transition-colors" aria-label="Toggle theme" data-theme-toggle>
                <span class="material-icons">dark_mode</span>
                <span class="material-icons hidden">light_mode</span>
            </button>
            <a href="{{ route('cart') }}" class="middle none center flex items-center gap-1.5 rounded-lg py-2.5 px-4 font-sans text-xs font-bold uppercase text-gray-600 hover:bg-gray-100 transition-colors" data-ripple-light="true">
                <span class="material-icons align-middle">shopping_cart</span>
                <span>{{ __('Cart') }}</span>
                @if(isset($cartCount) && $cartCount > 0)
                    <span class="rounded-full bg-blue-600 px-2 py-0.5 text-[10px] text-white">{{ $cartCount }}</span>
                @endif
            </a>
            @auth
                <a href="{{ route('account') }}" class="rounded-lg py-2.5 px-4 font-sans text-xs font-bold uppercase text-gray-600 hover:bg-gray-100">{{ __('Account') }}</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="rounded-lg py-2.5 px-4 font-sans text-xs font-bold uppercase text-gray-600 hover:bg-gray-100">{{ __('Logout') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="rounded-lg py-2.5 px-4 font-sans text-xs font-bold uppercase text-gray-600 hover:bg-gray-100">{{ __('Login') }}</a>
                <a href="{{ route('register') }}" class="rounded-lg bg-gray-900 py-2.5 px-4 font-sans text-xs font-bold uppercase text-white hover:bg-gray-800">{{ __('Register') }}</a>
            @endauth
        </div>

        <button type="button" class="middle none center rounded-lg p-2 font-sans text-xs font-bold uppercase text-gray-600 hover:bg-gray-100 md:hidden transition-colors" aria-label="Toggle menu" data-navbar="toggle">
            <span class="material-icons" data-navbar="icon-open">menu</span>
            <span class="material-icons hidden" data-navbar="icon-close">close</span>
        </button>
    </div>

    <div class="hidden w-full flex-col gap-2 border-t border-gray-200 bg-white px-4 py-3 md:hidden" data-navbar="mobile-menu">
        <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">{{ __('Home') }}</a>
        <a href="{{ route('categories') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">{{ __('Categories') }}</a>
        <a href="{{ route('home') }}#products" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">{{ __('Products') }}</a>
        <a href="{{ route('contact') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">{{ __('Contact') }}</a>
        <a href="{{ route('cart') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
            <span class="material-icons text-lg">shopping_cart</span>
            {{ __('Cart') }}
            @if(isset($cartCount) && $cartCount > 0)
                <span class="rounded-full bg-blue-600 px-2 py-0.5 text-xs text-white">{{ $cartCount }}</span>
            @endif
        </a>
        @auth
            <a href="{{ route('account') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">{{ __('Account') }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-100">{{ __('Logout') }}</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">{{ __('Login') }}</a>
            <a href="{{ route('register') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">{{ __('Register') }}</a>
        @endauth
    </div>
</nav>
