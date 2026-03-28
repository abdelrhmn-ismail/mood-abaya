@extends('frontend.layouts.app')

@section('title', ($q ? __('Search results') . ': ' . $q : __('Search')) . ' – ' . site_title())
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

    <section class="bg-slate-50 py-16 md:py-20">
        <div class="container mx-auto px-4">
            @if($q !== '')
                <p class="mb-6 text-brand-black/80">
                    {{ $products->total() === 0 ? __('No products found for') : __(':count results for', ['count' => $products->total()]) }} &ldquo;<strong class="text-brand-teal">{{ e($q) }}</strong>&rdquo;
                </p>
                <div class="flex flex-col gap-8 lg:flex-row lg:items-start">
                    <x-frontend.product-filters :filters="$filters" :preserveQueryKeys="['q']" />

                    <div class="min-w-0 flex-1">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                            @forelse($products as $product)
                                <x-frontend.product-card :product="$product" />
                            @empty
                                <p class="col-span-full py-12 text-center text-brand-black/70">{{ __('Try different keywords.') }}</p>
                            @endforelse
                        </div>
                        @if($products->hasPages())
                            <div class="mt-10 flex justify-center">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <p class="py-12 text-center text-brand-black/70">{{ __('Enter a search term above to find products.') }}</p>
            @endif
        </div>
    </section>
@endsection
