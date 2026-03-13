@extends('frontend.layouts.app')

@section('title', config('app.name') . ' – ' . __('Shop the Best'))
@section('description', __('Quality products for everyone. Shop with confidence.'))

@section('content')
    {{-- Hero slider (3 images) --}}
    <section class="relative h-[70vh] min-h-[420px] overflow-hidden bg-slate-900" data-hero-slider>
        <div class="absolute inset-0">
            <div class="absolute inset-0 transition-opacity duration-700 opacity-100" data-hero-slide style="background: url('https://images.unsplash.com/photo-1558171813-4c088753af8f?w=1920') center/cover no-repeat;"></div>
            <div class="absolute inset-0 transition-opacity duration-700 opacity-0 pointer-events-none" data-hero-slide style="background: url('https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1920') center/cover no-repeat;"></div>
            <div class="absolute inset-0 transition-opacity duration-700 opacity-0 pointer-events-none" data-hero-slide style="background: url('https://images.unsplash.com/photo-1583391733982-1cfec2046952?w=1920') center/cover no-repeat;"></div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center text-white">
            <h1 class="text-4xl font-bold tracking-tight drop-shadow-lg md:text-5xl lg:text-6xl">{{ __('Welcome to :name', ['name' => config('app.name')]) }}</h1>
            <p class="mt-4 max-w-xl text-lg text-white/95 md:text-xl">{{ __('Quality products for everyone. Shop with confidence.') }}</p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('categories') }}" class="rounded-xl bg-white px-8 py-3.5 text-sm font-semibold text-slate-900 shadow-lg transition hover:bg-white/95 hover:shadow-xl">
                    {{ __('Shop Now') }}
                </a>
                <a href="{{ route('categories') }}#categories" class="rounded-xl border-2 border-white/90 bg-white/10 px-8 py-3.5 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/20">
                    {{ __('View Categories') }}
                </a>
            </div>
        </div>
        <div class="absolute bottom-6 left-1/2 flex -translate-x-1/2 gap-2" aria-hidden="true">
            <button type="button" class="h-2.5 w-2.5 rounded-full bg-white/90 transition hover:bg-white" data-hero-dot aria-current="true"></button>
            <button type="button" class="h-2.5 w-2.5 rounded-full bg-white/40 transition hover:bg-white" data-hero-dot aria-current="false"></button>
            <button type="button" class="h-2.5 w-2.5 rounded-full bg-white/40 transition hover:bg-white" data-hero-dot aria-current="false"></button>
        </div>
    </section>

    {{-- Categories --}}
    <section id="categories" class="bg-white py-20 md:py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-3xl font-bold text-slate-900 md:text-4xl">{{ __('Shop by Category') }}</h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-slate-600">{{ __('Browse our collections') }}</p>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="group relative overflow-hidden rounded-2xl bg-slate-50 shadow-sm transition hover:shadow-xl">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-48 w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="flex h-48 w-full items-center justify-center bg-gradient-to-br from-slate-200 to-slate-100">
                                <span class="material-icons text-6xl text-slate-400">category</span>
                            </div>
                        @endif
                        <div class="p-5">
                            <h3 class="font-semibold text-slate-900">{{ $category->name }}</h3>
                            <p class="mt-1 text-sm text-slate-500">{{ $category->products_count }} {{ __('Products') }}</p>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-slate-600">{{ __('No categories yet.') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Featured products --}}
    <section id="products" class="bg-slate-50 py-20 md:py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-3xl font-bold text-slate-900 md:text-4xl">{{ __('Featured Products') }}</h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-slate-600">{{ __('Handpicked for you') }}</p>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($products as $product)
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-xl">
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="aspect-square w-full object-cover transition duration-300 hover:scale-105" loading="lazy">
                            @else
                                <div class="aspect-square w-full bg-slate-100 flex items-center justify-center">
                                    <span class="material-icons text-6xl text-slate-300">inventory_2</span>
                                </div>
                            @endif
                            <div class="p-5">
                                <h3 class="font-semibold text-slate-900">{{ $product->name }}</h3>
                                <p class="mt-2 text-lg font-bold text-slate-800">{{ number_format($product->price, 2) }} {{ __('SAR') }}</p>
                            </div>
                        </a>
                        <div class="border-t border-slate-100 p-4">
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 py-3 text-sm font-semibold text-white transition hover:bg-slate-800" data-ripple-light="true">
                                    {{ __('Add to Cart') }}
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full text-center text-slate-600">{{ __('No products yet.') }}</p>
                @endforelse
            </div>
            @if(isset($products) && $products->isNotEmpty())
                <div class="mt-12 text-center">
                    <a href="{{ route('categories') }}" class="inline-flex items-center gap-2 rounded-xl border-2 border-slate-900 px-6 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-900 hover:text-white">
                        {{ __('View All Products') }}
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA / Newsletter --}}
    <section class="bg-slate-900 py-20 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold md:text-3xl">{{ __('Get 10% off your first order') }}</h2>
            <p class="mx-auto mt-3 max-w-lg text-slate-300">{{ __('Subscribe to our newsletter') }}</p>
            <form class="mx-auto mt-8 flex max-w-md flex-col gap-3 sm:flex-row sm:gap-2" data-newsletter="form">
                <input type="email" placeholder="{{ __('Enter your email') }}" class="flex-1 rounded-xl border border-slate-600 bg-white/5 px-4 py-3 text-white placeholder-slate-400 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/30">
                <button type="submit" class="rounded-xl bg-white px-6 py-3 font-semibold text-slate-900 transition hover:bg-slate-100" data-ripple-light="true">
                    {{ __('Subscribe') }}
                </button>
            </form>
        </div>
    </section>
@endsection
