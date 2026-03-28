@extends('frontend.layouts.app')

@section('title', site_title() . ' – ' . __('Shop the Best'))
@section('description', __('Quality products for everyone. Shop with confidence.'))

@section('content')
    @php
        $heroRaw = fn ($key, $default) => \App\Models\Setting::get($key, $default);
        $heroUrl = function ($val) {
            if (empty($val)) return $val;
            return str_starts_with($val, 'http') ? $val : \Illuminate\Support\Facades\Storage::url($val);
        };
        $hero1 = $heroUrl($heroRaw('hero_home_1', 'https://images.unsplash.com/photo-1558171813-4c088753af8f?w=1920'));
        $hero2 = $heroUrl($heroRaw('hero_home_2', 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1920'));
        $hero3 = $heroUrl($heroRaw('hero_home_3', 'https://images.unsplash.com/photo-1583391733982-1cfec2046952?w=1920'));
    @endphp

    {{-- Hero slider --}}
    <section class="relative h-[70vh] min-h-[420px] overflow-hidden bg-brand-teal" data-hero-slider>
        <div class="absolute inset-0">
            <div class="absolute inset-0 transition-opacity duration-700 opacity-100" data-hero-slide style="background: url('{{ $hero1 }}') center/cover no-repeat;"></div>
            <div class="absolute inset-0 transition-opacity duration-700 opacity-0 pointer-events-none" data-hero-slide style="background: url('{{ $hero2 }}') center/cover no-repeat;"></div>
            <div class="absolute inset-0 transition-opacity duration-700 opacity-0 pointer-events-none" data-hero-slide style="background: url('{{ $hero3 }}') center/cover no-repeat;"></div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-brand-black/70 via-brand-teal/40 to-transparent"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center text-white">
            <h1 class="text-4xl font-bold tracking-tight drop-shadow-lg md:text-5xl lg:text-6xl">{{ __('Welcome to :name', ['name' => site_title()]) }}</h1>
            <p class="mt-4 max-w-xl text-lg text-white/95 md:text-xl">{{ __('Quality products for everyone. Shop with confidence.') }}</p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('categories') }}" class="rounded-xl bg-brand-white px-8 py-3.5 text-sm font-semibold text-brand-teal shadow-lg transition hover:bg-brand-gold hover:text-brand-black">
                    {{ __('Shop Now') }}
                </a>
                <a href="{{ route('categories') }}#categories" class="rounded-xl border-2 border-white/90 bg-white/10 px-8 py-3.5 text-sm font-semibold text-white backdrop-blur transition hover:bg-brand-gold/30 hover:border-brand-gold">
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

    {{-- About Us (homepage teaser) --}}
    <section id="about" class="border-b border-slate-200 bg-brand-white py-16 md:py-20">
        <div class="container mx-auto px-4">
            <div class="mx-auto max-w-4xl text-center">
                <h2 class="text-3xl font-bold text-brand-black md:text-4xl">{{ __('About Us') }}</h2>
                <p class="mt-4 text-lg leading-relaxed text-brand-black/80">
                    {{ __('We offer a curated selection of abayas, jilbabs, and hijabs for the modern modest wardrobe. Quality fabrics, timeless designs, and a seamless shopping experience.') }}
                </p>
                <a href="{{ route('about') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-teal px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-teal-dark">
                    {{ __('Learn more about us') }}
                    <span class="material-icons text-lg">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    @include('frontend.partials.testimonials-block')

    {{-- Trust strip --}}
    <section class="border-b border-slate-200 bg-brand-white py-4">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-center gap-8 md:gap-12">
                <div class="flex items-center gap-3 text-brand-black/80">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-gold/20 text-brand-teal"><span class="material-icons text-xl">local_shipping</span></span>
                    <span class="text-sm font-medium">{{ __('Shipping') }}</span>
                </div>
                <div class="flex items-center gap-3 text-brand-black/80">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-gold/20 text-brand-teal"><span class="material-icons text-xl">verified_user</span></span>
                    <span class="text-sm font-medium">{{ __('Secure payment') }}</span>
                </div>
                <div class="flex items-center gap-3 text-brand-black/80">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-gold/20 text-brand-teal"><span class="material-icons text-xl">assignment_return</span></span>
                    <span class="text-sm font-medium">{{ __('Easy returns') }}</span>
                </div>
                <div class="flex items-center gap-3 text-brand-black/80">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-gold/20 text-brand-teal"><span class="material-icons text-xl">support_agent</span></span>
                    <span class="text-sm font-medium">{{ __('Support') }}</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Discover our collection (banner) --}}
    <section class="relative overflow-hidden bg-brand-teal py-16 md:py-20">
        <div class="absolute inset-0 bg-gradient-to-br from-brand-teal-dark/50 to-brand-teal/80"></div>
        <div class="container relative mx-auto px-4 text-center text-white">
            <h2 class="text-3xl font-bold md:text-4xl">{{ __('Discover our collection') }}</h2>
            <p class="mx-auto mt-3 max-w-2xl text-white/90">
                {{ __('Shop abayas, jilbabs, and hijabs crafted with care. New styles added regularly.') }}
            </p>
            <a href="{{ route('categories') }}" class="mt-8 inline-flex items-center gap-2 rounded-xl bg-brand-gold px-8 py-3.5 font-semibold text-brand-black transition hover:bg-brand-gold-dark">
                {{ __('Browse all categories') }}
                <span class="material-icons">storefront</span>
            </a>
        </div>
    </section>

    {{-- Categories --}}
    <section id="categories" class="bg-slate-50 py-20 md:py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-3xl font-bold text-brand-black md:text-4xl">{{ __('Shop by Category') }}</h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-brand-black/70">{{ __('Browse our collections') }}</p>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-brand-white shadow-sm transition hover:shadow-xl hover:border-brand-teal/30">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-48 w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="flex h-48 w-full items-center justify-center bg-gradient-to-br from-brand-teal/10 to-brand-gold/10">
                                <span class="material-icons text-6xl text-brand-teal/50">category</span>
                            </div>
                        @endif
                        <div class="border-t border-slate-100 bg-brand-white p-5 transition group-hover:bg-brand-gold/5">
                            <h3 class="font-semibold text-brand-black">{{ $category->name }}</h3>
                            <p class="mt-1 text-sm text-brand-black/60">{{ $category->products_count }} {{ __('Products') }}</p>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-brand-black/70">{{ __('No categories yet.') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    @if(isset($featuredProducts) && $featuredProducts->isNotEmpty())
    {{-- Featured products --}}
    <section class="bg-brand-white py-20 md:py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-3xl font-bold text-brand-black md:text-4xl">{{ __('Featured Products') }}</h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-brand-black/70">{{ __('Handpicked for you') }}</p>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($featuredProducts as $product)
                    <x-frontend.product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('categories') }}" class="inline-flex items-center gap-2 rounded-xl border-2 border-brand-teal px-6 py-3 text-sm font-semibold text-brand-teal transition hover:bg-brand-teal hover:text-white">
                    {{ __('View All Products') }}
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- New arrivals / Latest products --}}
    <section id="products" class="bg-slate-50 py-20 md:py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-3xl font-bold text-brand-black md:text-4xl">{{ isset($featuredProducts) && $featuredProducts->isNotEmpty() ? __('New arrivals') : __('Featured Products') }}</h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-brand-black/70">{{ isset($featuredProducts) && $featuredProducts->isNotEmpty() ? __('Just landed') : __('Handpicked for you') }}</p>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($products as $product)
                    <x-frontend.product-card :product="$product" />
                @empty
                    <p class="col-span-full text-center text-brand-black/70">{{ __('No products yet.') }}</p>
                @endforelse
            </div>
            @if(isset($products) && $products->isNotEmpty())
                <div class="mt-12 text-center">
                    <a href="{{ route('categories') }}" class="inline-flex items-center gap-2 rounded-xl border-2 border-brand-teal px-6 py-3 text-sm font-semibold text-brand-teal transition hover:bg-brand-teal hover:text-white">
                        {{ __('View All Products') }}
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- Stats / social proof --}}
    <section class="border-y border-slate-200 bg-slate-50 py-12 md:py-14">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 md:gap-12">
                <div class="text-center">
                    <p class="text-3xl font-bold text-brand-teal md:text-4xl">{{ __('Quality first') }}</p>
                    <p class="mt-1 text-sm font-medium text-brand-black/70">{{ __('Every piece we sell') }}</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-brand-teal md:text-4xl">{{ __('Fast shipping') }}</p>
                    <p class="mt-1 text-sm font-medium text-brand-black/70">{{ __('Across the region') }}</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-brand-teal md:text-4xl">{{ __('Easy returns') }}</p>
                    <p class="mt-1 text-sm font-medium text-brand-black/70">{{ __('Hassle-free policy') }}</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-brand-teal md:text-4xl">{{ __('Support') }}</p>
                    <p class="mt-1 text-sm font-medium text-brand-black/70">{{ __('We are here for you') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Follow us / CTA --}}
    <section class="bg-brand-white py-16 md:py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-brand-black md:text-3xl">{{ __('Stay in the loop') }}</h2>
            <p class="mx-auto mt-3 max-w-xl text-brand-black/70">
                {{ __('Subscribe for new arrivals, exclusive offers, and styling tips.') }}
            </p>
        </div>
    </section>

    {{-- CTA / Newsletter --}}
    <section class="bg-brand-teal py-20 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold md:text-3xl">{{ __('Get 10% off your first order') }}</h2>
            <p class="mx-auto mt-3 max-w-lg text-white/80">{{ __('Subscribe to our newsletter') }}</p>
            <form action="{{ route('newsletter.store') }}" method="POST" class="mx-auto mt-8 flex max-w-md flex-col gap-3 sm:flex-row sm:gap-2" data-newsletter="form">
                @csrf
                <input type="email" name="email" placeholder="{{ __('Enter your email') }}" required class="flex-1 rounded-xl border border-white/30 bg-white/10 px-4 py-3 text-white placeholder-white/60 focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/40" aria-label="{{ __('Enter your email') }}">
                <button type="submit" class="rounded-xl bg-brand-gold px-6 py-3 font-semibold text-brand-black transition hover:bg-brand-gold-dark" data-ripple-light="true">
                    {{ __('Subscribe') }}
                </button>
            </form>
            <p class="mx-auto mt-3 min-h-[1.5rem] text-sm text-white/90" data-newsletter="message" aria-live="polite"></p>
        </div>
    </section>
@endsection
