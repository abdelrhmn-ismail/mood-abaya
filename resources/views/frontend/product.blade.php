@extends('frontend.layouts.app')

@section('title', ($product->meta_title ?: $product->name) . ' – ' . config('app.name'))
@section('description', $product->meta_description ?: Str::limit(strip_tags($product->description ?? ''), 160))
@section('meta_keywords', $product->meta_keywords ?? '')
@section('og_image', $product->og_image ? (str_starts_with($product->og_image, 'http') ? $product->og_image : asset($product->og_image)) : '')

@section('content')
    <section class="bg-slate-50 py-8 md:py-12">
        <div class="container mx-auto px-4">
            {{-- Breadcrumb --}}
            <nav class="mb-6 flex flex-wrap items-center gap-1 text-sm text-brand-black/70" aria-label="Breadcrumb">
                <a href="{{ route('categories') }}" class="transition hover:text-brand-teal">{{ __('Categories') }}</a>
                <span class="material-icons text-base text-brand-black/40">chevron_right</span>
                <a href="{{ route('categories.show', $product->category->slug) }}" class="transition hover:text-brand-teal">{{ $product->category->name }}</a>
                <span class="material-icons text-base text-brand-black/40">chevron_right</span>
                <span class="font-medium text-brand-black">{{ $product->name }}</span>
            </nav>

            <div class="mx-auto max-w-6xl">
                <div class="grid gap-10 lg:grid-cols-2 lg:gap-14">
                    {{-- Image --}}
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-brand-white shadow-sm">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="aspect-square w-full object-cover">
                        @else
                            <div class="flex aspect-square w-full items-center justify-center bg-slate-100">
                                <span class="material-icons text-8xl text-slate-300">inventory_2</span>
                            </div>
                        @endif
                    </div>

                    {{-- Details (sticky on desktop) --}}
                    <div class="lg:sticky lg:top-24 lg:self-start">
                        @if($product->hasDiscount())
                            <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-800">
                                <span class="material-icons text-lg">local_offer</span> {{ __('Save') }} {{ $product->discountPercent() }}%
                            </span>
                        @endif
                        <h1 class="mt-3 text-3xl font-bold tracking-tight text-brand-black md:text-4xl">{{ $product->name }}</h1>

                        {{-- Price & rating --}}
                        <div class="mt-4 flex flex-wrap items-center gap-4">
                            <div class="flex items-baseline gap-2">
                                <p class="text-2xl font-bold text-brand-teal">{{ number_format($product->price, 2) }} {{ __('SAR') }}</p>
                                @if($product->hasDiscount())
                                    <p class="text-lg text-slate-500 line-through">{{ number_format($product->compare_at_price, 2) }} {{ __('SAR') }}</p>
                                @endif
                            </div>
                            @if($product->visibleReviewsCount() > 0)
                                <div class="flex items-center gap-1.5 rounded-lg bg-brand-gold/10 px-3 py-1.5">
                                    @for($s = 1; $s <= 5; $s++)
                                        <span class="material-icons text-lg {{ $s <= round($product->averageRating()) ? 'text-amber-500' : 'text-slate-300' }}">star</span>
                                    @endfor
                                    <span class="ml-1 text-sm font-medium text-brand-black">({{ $product->visibleReviewsCount() }} {{ $product->visibleReviewsCount() === 1 ? __('review') : __('reviews') }})</span>
                                </div>
                            @endif
                        </div>

                        {{-- Stock --}}
                        <div class="mt-5 flex items-center gap-2 rounded-xl border border-slate-200 bg-brand-white px-4 py-3">
                            @if($product->stock > 0)
                                <span class="material-icons text-brand-teal">check_circle</span>
                                <span class="text-sm font-medium text-brand-black">{{ __('In stock') }}: {{ $product->stock }}</span>
                            @else
                                <span class="material-icons text-amber-600">cancel</span>
                                <span class="text-sm font-medium text-amber-600">{{ __('Out of stock') }}</span>
                            @endif
                        </div>

                        @if($product->description)
                            <div class="mt-6 text-brand-black/80 prose prose-slate max-w-none prose-headings:text-brand-black prose-a:text-brand-teal">
                                {!! safe_html(Str::limit(strip_tags($product->description), 200)) !!}
                                @if(strlen(strip_tags($product->description)) > 200)
                                    <span class="text-brand-teal">…</span>
                                @endif
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div class="mt-8 flex flex-wrap items-center gap-3">
                            <form action="{{ route('cart.store') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-teal px-8 py-4 font-semibold text-white shadow-lg transition hover:bg-brand-teal-dark disabled:opacity-50 disabled:pointer-events-none" @if($product->stock < 1) disabled @endif>
                                    <span class="material-icons">shopping_cart</span>
                                    {{ __('Add to Cart') }}
                                </button>
                            </form>
                            <div class="inline-flex">
                                @include('frontend.partials.wishlist-button', ['product' => $product])
                            </div>
                        </div>

                        {{-- Trust line --}}
                        <div class="mt-8 flex flex-wrap gap-6 border-t border-slate-200 pt-6 text-sm text-brand-black/70">
                            <span class="flex items-center gap-2"><span class="material-icons text-brand-teal text-xl">local_shipping</span> {{ __('Shipping') }}</span>
                            <span class="flex items-center gap-2"><span class="material-icons text-brand-teal text-xl">assignment_return</span> {{ __('Returns') }}</span>
                            <span class="flex items-center gap-2"><span class="material-icons text-brand-teal text-xl">verified_user</span> {{ __('Secure payment') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Full description (expand or always visible) --}}
                @if($product->description && strlen(strip_tags($product->description)) > 200)
                    <div class="mt-14 rounded-2xl border border-slate-200 bg-brand-white p-6 md:p-8">
                        <h2 class="text-xl font-bold text-brand-black">{{ __('Description') }}</h2>
                        <div class="mt-4 text-brand-black/80 prose prose-slate max-w-none prose-headings:text-brand-black prose-a:text-brand-teal">
                            {!! safe_html($product->description) !!}
                        </div>
                    </div>
                @elseif($product->description)
                    <div class="mt-14 rounded-2xl border border-slate-200 bg-brand-white p-6 md:p-8">
                        <h2 class="text-xl font-bold text-brand-black">{{ __('Description') }}</h2>
                        <div class="mt-4 text-brand-black/80 prose prose-slate max-w-none">
                            {!! safe_html($product->description) !!}
                        </div>
                    </div>
                @endif

                {{-- Reviews --}}
                @if($product->reviews->isNotEmpty())
                    <div class="mt-14 rounded-2xl border border-slate-200 bg-brand-white p-6 md:p-8">
                        <h2 class="text-xl font-bold text-brand-black">{{ __('Reviews') }} ({{ $product->reviews->count() }})</h2>
                        <ul class="mt-6 space-y-5">
                            @foreach($product->reviews as $review)
                                <li class="flex gap-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4 transition hover:border-brand-teal/20">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-gold/20 text-brand-teal">
                                        <span class="material-icons">person</span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center justify-between gap-2">
                                            <div class="flex items-center gap-2">
                                                @for($s = 1; $s <= 5; $s++)
                                                    <span class="material-icons text-lg {{ $s <= $review->rating ? 'text-amber-500' : 'text-slate-300' }}">{{ $s <= $review->rating ? 'star' : 'star_border' }}</span>
                                                @endfor
                                                <span class="text-sm font-semibold text-brand-black">{{ $review->user->name ?? __('Customer') }}</span>
                                            </div>
                                            <span class="text-xs text-brand-black/50">{{ $review->created_at->format('d M Y') }}</span>
                                        </div>
                                        @if($review->comment)
                                            <p class="mt-2 text-sm text-brand-black/80">{{ $review->comment }}</p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
