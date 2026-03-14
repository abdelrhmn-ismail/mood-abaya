@extends('frontend.layouts.app')

@section('title', ($q ? __('Search results') . ': ' . $q : __('Search')) . ' – ' . config('app.name'))
@section('description', $q ? __('Search results for') . ' ' . $q : __('Search products'))

@section('content')
    @php
        $searchSubtitle = $q ? __('Search results for') . ' "' . e($q) . '"' : __('Find products by name');
    @endphp
    <x-frontend.hero-header
        :title="$q ? __('Search results') : __('Search')"
        :subtitle="$searchSubtitle"
        setting="hero_search"
    />

    <section class="bg-white py-16 md:py-20">
        <div class="container mx-auto px-4">
            @if($q !== '')
                <p class="mb-8 text-slate-600">
                    {{ $products->count() === 0 ? __('No products found for') : __(':count results for', ['count' => $products->count()]) }} &ldquo;<strong>{{ e($q) }}</strong>&rdquo;
                </p>
                <div class="mx-auto grid max-w-5xl grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @forelse($products as $product)
                        <a href="{{ route('products.show', $product->slug) }}" class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-xl">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-56 w-full object-cover transition duration-300 group-hover:scale-105">
                            @else
                                <div class="flex h-56 w-full items-center justify-center bg-slate-100">
                                    <span class="material-icons text-6xl text-slate-300">inventory_2</span>
                                </div>
                            @endif
                            <div class="p-5">
                                @if($product->hasDiscount())
                                    <span class="inline-block rounded bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-800">{{ __('Save') }} {{ $product->discountPercent() }}%</span>
                                @endif
                                <h2 class="font-semibold text-slate-900">{{ $product->name }}</h2>
                                <div class="mt-2 flex flex-wrap items-baseline gap-1.5">
                                    <span class="text-lg font-bold text-slate-800">{{ number_format($product->price, 2) }} {{ __('SAR') }}</span>
                                    @if($product->hasDiscount())
                                        <span class="text-sm text-slate-500 line-through">{{ number_format($product->compare_at_price, 2) }} {{ __('SAR') }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="col-span-full text-center text-slate-600">{{ __('Try different keywords.') }}</p>
                    @endforelse
                </div>
            @else
                <p class="text-center text-slate-600">{{ __('Enter a search term above to find products.') }}</p>
            @endif
        </div>
    </section>
@endsection
