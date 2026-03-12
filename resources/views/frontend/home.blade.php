@extends('frontend.layouts.app')

@section('title', config('app.name') . ' – ' . __('Shop the Best'))
@section('description', __('Quality products for everyone. Shop with confidence.'))

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-gray-900 to-blue-gray-800 py-20 text-white md:py-28">
        <div class="container mx-auto px-4">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="mb-4 font-sans text-4xl font-bold tracking-normal md:text-5xl">
                    {{ __('Welcome to :name', ['name' => config('app.name')]) }}
                </h1>
                <p class="mb-8 text-lg text-blue-gray-200">
                    {{ __('Quality products for everyone. Shop with confidence.') }}
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('categories') }}"
                       class="middle none center rounded-lg bg-white py-3 px-6 font-sans text-xs font-bold uppercase text-gray-900 shadow-md shadow-gray-900/10 transition-all hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                       data-ripple-light="true">
                        {{ __('Shop Now') }}
                    </a>
                    <a href="{{ route('categories') }}#categories"
                       class="middle none center rounded-lg border border-white/80 bg-transparent py-3 px-6 font-sans text-xs font-bold uppercase text-white transition-all hover:bg-white/10 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50"
                       data-ripple-light="true">
                        {{ __('View Categories') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    <section id="categories" class="py-16 md:py-20">
        <div class="container mx-auto px-4">
            <h2 class="mb-10 text-center font-sans text-3xl font-bold text-gray-900 md:text-4xl">
                {{ __('Shop by Category') }}
            </h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($categories ?? [] as $category)
                    <a href="{{ route('categories.show', $category->slug) }}"
                       class="flex flex-col items-center rounded-xl border border-gray-200 bg-white p-6 shadow-md transition-all hover:shadow-lg hover:border-blue-gray-200"
                       data-ripple-light="true">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="mb-3 h-16 w-16 rounded-full object-cover">
                        @else
                            <span class="material-icons mb-3 text-5xl text-blue-gray-600">category</span>
                        @endif
                        <h3 class="font-sans text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $category->products_count }} {{ __('Products') }}</p>
                    </a>
                @empty
                    <p class="col-span-full text-center text-gray-600">{{ __('No categories yet.') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Featured products --}}
    <section id="products" class="bg-gray-100 py-16 md:py-20">
        <div class="container mx-auto px-4">
            <h2 class="mb-10 text-center font-sans text-3xl font-bold text-gray-900 md:text-4xl">
                {{ __('Featured Products') }}
            </h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($products ?? [] as $product)
                    <article class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-md transition-all hover:shadow-lg">
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="aspect-square w-full object-cover" loading="lazy">
                            @else
                                <div class="aspect-square w-full bg-gray-100 flex items-center justify-center">
                                    <span class="material-icons text-6xl text-gray-400">inventory_2</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-sans font-semibold text-gray-900">{{ $product->name }}</h3>
                                <p class="mt-1 font-sans text-lg font-bold text-blue-gray-900">{{ number_format($product->price, 2) }} {{ __('SAR') }}</p>
                            </div>
                        </a>
                        <div class="border-t border-gray-100 p-3">
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                        class="middle none center flex w-full items-center justify-center gap-2 rounded-lg bg-gray-900 py-2.5 px-4 font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:bg-gray-800 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50"
                                        data-ripple-light="true">
                                    {{ __('Add to Cart') }}
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full text-center text-gray-600">{{ __('No products yet.') }}</p>
                @endforelse
            </div>
            @if(isset($products) && $products->isNotEmpty())
                <div class="mt-10 text-center">
                    <a href="{{ route('categories') }}"
                       class="middle none center inline-block rounded-lg border border-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-gray-800 transition-all hover:bg-gray-900 hover:text-white"
                       data-ripple-light="true">
                        {{ __('View All Products') }}
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 md:py-20">
        <div class="container mx-auto px-4">
            <div class="rounded-2xl bg-blue-gray-900 px-6 py-12 text-center text-white md:py-16">
                <h2 class="mb-4 font-sans text-2xl font-bold md:text-3xl">
                    {{ __('Get 10% off your first order') }}
                </h2>
                <p class="mx-auto mb-6 max-w-lg text-blue-gray-200">
                    {{ __('Enter your email') }} – {{ __('Subscribe') }}
                </p>
                <form class="mx-auto flex max-w-md flex-col gap-3 sm:flex-row sm:gap-2" data-newsletter="form">
                    <input type="email"
                           placeholder="{{ __('Enter your email') }}"
                           class="flex-1 rounded-lg border border-gray-600 bg-white/5 px-4 py-3 text-white placeholder-gray-400 focus:border-white focus:outline-none focus:ring-1 focus:ring-white">
                    <button type="submit"
                            class="middle none center rounded-lg bg-white py-3 px-6 font-sans text-xs font-bold uppercase text-gray-900 shadow-md transition-all hover:shadow-lg focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50"
                            data-ripple-light="true">
                        {{ __('Subscribe') }}
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
