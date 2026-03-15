@extends('frontend.layouts.app')

@section('title', $category->name . ' – ' . config('app.name'))
@section('description', Str::limit(strip_tags($category->description ?? ''), 160) ?: $category->name)

@section('content')
    <section class="bg-slate-50 py-10 md:py-14">
        <div class="container mx-auto px-4">
            <nav class="mb-6 flex flex-wrap items-center gap-1 text-sm text-brand-black/70" aria-label="Breadcrumb">
                <a href="{{ route('categories') }}" class="transition hover:text-brand-teal">{{ __('Categories') }}</a>
                <span class="material-icons text-base text-brand-black/40">chevron_right</span>
                <span class="font-medium text-brand-black">{{ $category->name }}</span>
            </nav>
            <h1 class="text-4xl font-bold tracking-tight text-brand-black md:text-5xl">{{ $category->name }}</h1>
            @if($category->description)
                <div class="mt-4 max-w-2xl text-brand-black/80 prose prose-slate prose-headings:text-brand-black prose-a:text-brand-teal">{!! safe_html($category->description) !!}</div>
            @endif
            <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse($products as $product)
                    <article class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-brand-white shadow-sm transition hover:shadow-xl hover:border-brand-teal/20">
                        <div class="absolute right-2 top-2 z-10" onclick="event.preventDefault(); event.stopPropagation();">
                            @include('frontend.partials.wishlist-button', ['product' => $product])
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-56 w-full object-cover transition duration-300 group-hover:scale-105">
                            @else
                                <div class="flex h-56 w-full items-center justify-center bg-slate-100">
                                    <span class="material-icons text-6xl text-slate-300">inventory_2</span>
                                </div>
                            @endif
                            <div class="border-t border-slate-100 p-5">
                                @if($product->hasDiscount())
                                    <span class="inline-block rounded bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-800">{{ __('Save') }} {{ $product->discountPercent() }}%</span>
                                @endif
                                <h2 class="mt-1 font-semibold text-brand-black group-hover:text-brand-teal">{{ $product->name }}</h2>
                                <div class="mt-2 flex flex-wrap items-baseline gap-1.5">
                                    <span class="text-lg font-bold text-brand-teal">{{ number_format($product->price, 2) }} {{ __('SAR') }}</span>
                                    @if($product->hasDiscount())
                                        <span class="text-sm text-slate-500 line-through">{{ number_format($product->compare_at_price, 2) }} {{ __('SAR') }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </article>
                @empty
                    <p class="col-span-full py-12 text-center text-brand-black/70">{{ __('No products in this category.') }}</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
