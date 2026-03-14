@extends('frontend.layouts.app')

@section('title', $category->name . ' – ' . config('app.name'))
@section('description', Str::limit(strip_tags($category->description ?? ''), 160) ?: $category->name)

@section('content')
    <section class="bg-white py-12 md:py-16">
        <div class="container mx-auto px-4">
            <nav class="mb-8 text-sm text-slate-600">
                <a href="{{ route('categories') }}" class="hover:text-slate-900">{{ __('Categories') }}</a>
                <span class="mx-2">/</span>
                <span class="font-medium text-slate-900">{{ $category->name }}</span>
            </nav>
            <h1 class="text-4xl font-bold text-slate-900 md:text-5xl">{{ $category->name }}</h1>
            @if($category->description)
                <div class="mt-4 max-w-2xl text-slate-600 prose prose-slate">{!! safe_html($category->description) !!}</div>
            @endif
            <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
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
                    <p class="col-span-full text-slate-600">{{ __('No products in this category.') }}</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
