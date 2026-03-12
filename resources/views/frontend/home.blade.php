@extends('frontend.layouts.app')

@section('title', config('app.name') . ' – Shop the Best')
@section('description', 'Discover our curated collection. Quality products, great prices.')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-gray-900 to-blue-gray-800 py-20 text-white md:py-28">
        <div class="container mx-auto px-4">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="mb-4 font-sans text-4xl font-bold tracking-normal md:text-5xl">
                    Welcome to {{ config('app.name') }}
                </h1>
                <p class="mb-8 text-lg text-blue-gray-200">
                    Discover quality products for every need. Shop with confidence and enjoy fast delivery.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#products"
                       class="middle none center rounded-lg bg-white py-3 px-6 font-sans text-xs font-bold uppercase text-gray-900 shadow-md shadow-gray-900/10 transition-all hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                       data-ripple-light="true">
                        Shop Now
                    </a>
                    <a href="#categories"
                       class="middle none center rounded-lg border border-white/80 bg-transparent py-3 px-6 font-sans text-xs font-bold uppercase text-white transition-all hover:bg-white/10 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50"
                       data-ripple-light="true">
                        View Categories
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    <section id="categories" class="py-16 md:py-20">
        <div class="container mx-auto px-4">
            <h2 class="mb-10 text-center font-sans text-3xl font-bold text-gray-900 md:text-4xl">
                Shop by Category
            </h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['name' => 'Fashion', 'icon' => 'checkroom', 'count' => '120+ items'],
                    ['name' => 'Electronics', 'icon' => 'devices', 'count' => '85+ items'],
                    ['name' => 'Home & Living', 'icon' => 'home', 'count' => '95+ items'],
                    ['name' => 'Accessories', 'icon' => 'watch', 'count' => '60+ items'],
                ] as $category)
                    <a href="#"
                       class="flex flex-col items-center rounded-xl border border-gray-200 bg-white p-6 shadow-md transition-all hover:shadow-lg hover:border-blue-gray-200"
                       data-ripple-light="true">
                        <span class="material-icons mb-3 text-5xl text-blue-gray-600">{{ $category['icon'] }}</span>
                        <h3 class="font-sans text-lg font-semibold text-gray-900">{{ $category['name'] }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $category['count'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured products --}}
    <section id="products" class="bg-gray-100 py-16 md:py-20">
        <div class="container mx-auto px-4">
            <h2 class="mb-10 text-center font-sans text-3xl font-bold text-gray-900 md:text-4xl">
                Featured Products
            </h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['name' => 'Classic Cotton Tee', 'price' => '29.99', 'image' => 'https://placehold.co/400x400/f8fafc/64748b?text=Tee'],
                    ['name' => 'Wireless Earbuds', 'price' => '79.99', 'image' => 'https://placehold.co/400x400/f8fafc/64748b?text=Earbuds'],
                    ['name' => 'Minimalist Watch', 'price' => '149.00', 'image' => 'https://placehold.co/400x400/f8fafc/64748b?text=Watch'],
                    ['name' => 'Leather Bag', 'price' => '89.99', 'image' => 'https://placehold.co/400x400/f8fafc/64748b?text=Bag'],
                ] as $product)
                    <article class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-md transition-all hover:shadow-lg">
                        <a href="#" class="block">
                            <div class="aspect-square w-full bg-gray-100">
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-full w-full object-cover" loading="lazy">
                            </div>
                            <div class="p-4">
                                <h3 class="font-sans font-semibold text-gray-900">{{ $product['name'] }}</h3>
                                <p class="mt-1 font-sans text-lg font-bold text-blue-gray-900">${{ $product['price'] }}</p>
                            </div>
                        </a>
                        <div class="border-t border-gray-100 p-3">
                            <button type="button"
                                    class="middle none center w-full rounded-lg bg-gray-900 py-2.5 px-4 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-900/10 transition-all hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50"
                                    data-ripple-light="true">
                                Add to Cart
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-10 text-center">
                <a href="#"
                   class="middle none center inline-block rounded-lg border border-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-gray-800 transition-all hover:bg-gray-900 hover:text-white"
                   data-ripple-light="true">
                    View All Products
                </a>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 md:py-20">
        <div class="container mx-auto px-4">
            <div class="rounded-2xl bg-blue-gray-900 px-6 py-12 text-center text-white md:py-16">
                <h2 class="mb-4 font-sans text-2xl font-bold md:text-3xl">
                    Get 10% off your first order
                </h2>
                <p class="mx-auto mb-6 max-w-lg text-blue-gray-200">
                    Subscribe to our newsletter and receive a discount code right away.
                </p>
                <form class="mx-auto flex max-w-md flex-col gap-3 sm:flex-row sm:gap-2" data-newsletter="form">
                    <input type="email"
                           placeholder="Enter your email"
                           class="flex-1 rounded-lg border border-gray-600 bg-white/5 px-4 py-3 text-white placeholder-gray-400 focus:border-white focus:outline-none focus:ring-1 focus:ring-white">
                    <button type="submit"
                            class="middle none center rounded-lg bg-white py-3 px-6 font-sans text-xs font-bold uppercase text-gray-900 shadow-md transition-all hover:shadow-lg focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50"
                            data-ripple-light="true">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
