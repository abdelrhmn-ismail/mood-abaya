@extends('frontend.layouts.app')

@section('title', ($product->meta_title ?: $product->name) . ' – ' . config('app.name'))
@section('description', $product->meta_description ?: Str::limit(strip_tags($product->description ?? ''), 160))
@section('meta_keywords', $product->meta_keywords ?? '')
@section('og_image', $product->og_image ? (str_starts_with($product->og_image, 'http') ? $product->og_image : asset($product->og_image)) : '')

@section('content')
    <section class="bg-white py-12 md:py-16">
        <div class="container mx-auto px-4">
            <nav class="mb-8 text-sm text-slate-600">
                <a href="{{ route('categories') }}" class="hover:text-slate-900">{{ __('Categories') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('categories.show', $product->category->slug) }}" class="hover:text-slate-900">{{ $product->category->name }}</a>
                <span class="mx-2">/</span>
                <span class="font-medium text-slate-900">{{ $product->name }}</span>
            </nav>
            <div class="mx-auto max-w-5xl">
                <div class="grid gap-10 md:grid-cols-2">
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex aspect-square items-center justify-center">
                                <span class="material-icons text-8xl text-slate-300">inventory_2</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        @if($product->hasDiscount())
                            <span class="inline-block rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-800">{{ __('Save') }} {{ $product->discountPercent() }}%</span>
                        @endif
                        <h1 class="text-3xl font-bold text-slate-900 md:text-4xl">{{ $product->name }}</h1>
                        <div class="mt-4 flex flex-wrap items-baseline gap-2">
                            <p class="text-2xl font-bold text-slate-800">{{ number_format($product->price, 2) }} {{ __('SAR') }}</p>
                            @if($product->hasDiscount())
                                <p class="text-lg text-slate-500 line-through">{{ number_format($product->compare_at_price, 2) }} {{ __('SAR') }}</p>
                            @endif
                            @if($product->visibleReviewsCount() > 0)
                                <div class="flex items-center gap-1.5 text-sm text-slate-600">
                                    @for($s = 1; $s <= 5; $s++)
                                        <span class="material-icons text-lg {{ $s <= round($product->averageRating()) ? 'text-amber-400' : 'text-slate-300' }}">star</span>
                                    @endfor
                                    <span class="ml-1">({{ $product->visibleReviewsCount() }} {{ $product->visibleReviewsCount() === 1 ? __('review') : __('reviews') }})</span>
                                </div>
                            @endif
                        </div>
                        @if($product->description)
                            <div class="mt-6 text-slate-600 prose prose-slate max-w-none">{!! safe_html($product->description) !!}</div>
                        @endif
                        <p class="mt-6 text-sm text-slate-500">
                            @if($product->stock > 0)
                                {{ __('In stock') }}: {{ $product->stock }}
                            @else
                                <span class="font-medium text-amber-600">{{ __('Out of stock') }}</span>
                            @endif
                        </p>
                        <div class="mt-8">
                            <form action="{{ route('cart.store') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-8 py-3.5 font-semibold text-white transition hover:bg-slate-800 disabled:opacity-50 disabled:pointer-events-none" @if($product->stock < 1) disabled @endif>
                                    <span class="material-icons">shopping_cart</span>
                                    {{ __('Add to Cart') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if($product->reviews->isNotEmpty())
                <div class="mx-auto mt-12 max-w-5xl border-t border-slate-200 pt-12">
                    <h2 class="text-xl font-semibold text-slate-900">{{ __('Reviews') }} ({{ $product->reviews->count() }})</h2>
                    <ul class="mt-6 space-y-4">
                        @foreach($product->reviews as $review)
                            <li class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        @for($s = 1; $s <= 5; $s++)
                                            <span class="material-icons text-amber-400 text-lg">{{ $s <= $review->rating ? 'star' : 'star_border' }}</span>
                                        @endfor
                                        <span class="text-sm font-medium text-slate-700">{{ $review->user->name ?? __('Customer') }}</span>
                                    </div>
                                    <span class="text-xs text-slate-500">{{ $review->created_at->format('d M Y') }}</span>
                                </div>
                                @if($review->comment)
                                    <p class="mt-2 text-sm text-slate-600">{{ $review->comment }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>
@endsection
