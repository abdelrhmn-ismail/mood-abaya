<nav class="navbar sticky top-0 z-50 flex flex-wrap items-center justify-between bg-white py-2 text-gray-800 shadow-md"
     id="main-navbar">
    <div class="container mx-auto flex flex-wrap items-center justify-between px-4">
        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-xl font-bold text-gray-900">
            <span class="material-icons text-3xl">storefront</span>
            {{ config('app.name') }}
        </a>

        {{-- Desktop menu --}}
        <div class="hidden items-center gap-6 md:flex" data-navbar="menu">
            <a href="{{ url('/') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">Home</a>
            <a href="{{ url('/') }}#categories" class="text-sm font-medium text-gray-700 hover:text-gray-900">Categories</a>
            <a href="{{ url('/') }}#products" class="text-sm font-medium text-gray-700 hover:text-gray-900">Products</a>
            <a href="{{ url('/') }}#contact" class="text-sm font-medium text-gray-700 hover:text-gray-900">Contact</a>
        </div>

        {{-- Actions --}}
        <div class="hidden items-center gap-2 md:flex">
            <button type="button" class="middle none center rounded-lg p-2 font-sans text-xs font-bold uppercase text-gray-600 transition-all hover:bg-gray-100" aria-label="Search">
                <span class="material-icons">search</span>
            </button>
            <a href="#" class="middle none center rounded-lg py-2.5 px-4 font-sans text-xs font-bold uppercase text-gray-600 transition-all hover:bg-gray-100" data-ripple-light="true">
                <span class="material-icons align-middle mr-1">shopping_cart</span>
                Cart
            </a>
        </div>

        {{-- Mobile menu button --}}
        <button type="button" class="middle none center rounded-lg p-2 font-sans text-xs font-bold uppercase text-gray-600 transition-all hover:bg-gray-100 md:hidden" aria-label="Toggle menu" data-navbar="toggle">
            <span class="material-icons" data-navbar="icon-open">menu</span>
            <span class="material-icons hidden" data-navbar="icon-close">close</span>
        </button>
    </div>

    {{-- Mobile menu (collapsible) --}}
    <div class="hidden w-full flex-col gap-2 border-t border-gray-200 bg-white px-4 py-3 md:hidden" data-navbar="mobile-menu">
        <a href="{{ url('/') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">Home</a>
        <a href="{{ url('/') }}#categories" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">Categories</a>
        <a href="{{ url('/') }}#products" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">Products</a>
        <a href="{{ url('/') }}#contact" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">Contact</a>
        <a href="#" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
            <span class="material-icons text-lg">shopping_cart</span>
            Cart
        </a>
    </div>
</nav>
