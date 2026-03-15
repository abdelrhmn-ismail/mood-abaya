@extends('frontend.layouts.app')

@section('title', ($product->meta_title ?: $product->name) . ' – ' . config('app.name'))
@section('description', $product->meta_description ?: Str::limit(strip_tags($product->description ?? ''), 160))
@section('meta_keywords', $product->meta_keywords ?? '')
@section('og_image', $product->og_image ? (str_starts_with($product->og_image, 'http') ? $product->og_image : asset($product->og_image)) : '')

@push('scripts')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "BreadcrumbList",
        "itemListElement": [
            { "@@type": "ListItem", "position": 1, "name": {{ json_encode(__('Categories')) }}, "item": {{ json_encode(route('categories')) }} },
            { "@@type": "ListItem", "position": 2, "name": {{ json_encode($product->category->name) }}, "item": {{ json_encode(route('categories.show', $product->category->slug)) }} },
            { "@@type": "ListItem", "position": 3, "name": {{ json_encode($product->name) }} }
        ]
    }
    </script>
@endpush
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
                    {{-- Image gallery --}}
                    @php $displayImages = $product->getDisplayImages(); @endphp
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-brand-white shadow-sm" x-data="{ active: 0 }">
                        @if($displayImages->isEmpty())
                            <div class="flex aspect-square w-full items-center justify-center bg-slate-100">
                                <span class="material-icons text-8xl text-slate-300">inventory_2</span>
                            </div>
                        @else
                            <div class="relative aspect-square w-full bg-slate-100">
                                @foreach($displayImages as $index => $item)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $product->name }}"
                                         class="absolute inset-0 h-full w-full object-cover transition-opacity duration-300 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                                         :class="active === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                                @endforeach
                            </div>
                            @if($displayImages->count() > 1)
                                <div class="flex flex-wrap justify-center gap-2 border-t border-slate-100 bg-slate-50/50 p-3">
                                    @foreach($displayImages as $index => $item)
                                        <button type="button" class="h-14 w-14 shrink-0 overflow-hidden rounded-lg border-2 transition focus:ring-2 focus:ring-brand-teal focus:ring-offset-2"
                                                :class="active === {{ $index }} ? 'border-brand-teal ring-1 ring-brand-teal' : 'border-slate-200 hover:border-slate-300'"
                                                @@click="active = {{ $index }}"
                                                aria-label="{{ __('Image') }} {{ $index + 1 }}">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="" class="h-full w-full object-cover">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
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
                        @php $hasVariants = $product->hasVariants(); $variants = $product->variants; @endphp
                        <div class="mt-4 flex flex-wrap items-center gap-4">
                            <div class="flex items-baseline gap-2">
                                <p class="text-2xl font-bold text-brand-teal" id="product-price">{{ number_format($product->price, 2) }} {{ __('SAR') }}</p>
                                @if(!$hasVariants && $product->hasDiscount())
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

                        {{-- Stock (no variants) --}}
                        @if(!$hasVariants)
                        <div class="mt-5 flex items-center gap-2 rounded-xl border border-slate-200 bg-brand-white px-4 py-3">
                            @if($product->stock > 0)
                                <span class="material-icons text-brand-teal">check_circle</span>
                                <span class="text-sm font-medium text-brand-black">{{ __('In stock') }}: {{ $product->stock }}</span>
                            @else
                                <span class="material-icons text-amber-600">cancel</span>
                                <span class="text-sm font-medium text-amber-600">{{ __('Out of stock') }}</span>
                            @endif
                        </div>
                        @endif

                        @if($product->description)
                            <div class="mt-6 text-brand-black/80 prose prose-slate max-w-none prose-headings:text-brand-black prose-a:text-brand-teal">
                                {!! safe_html(Str::limit(strip_tags($product->description), 200)) !!}
                                @if(strlen(strip_tags($product->description)) > 200)
                                    <span class="text-brand-teal">…</span>
                                @endif
                            </div>
                        @endif

                        {{-- Variant selector + Add to cart (when has variants) --}}
                        @if($hasVariants)
                        <div class="mt-5 space-y-4" x-data="{ variantId: '', variant: null, price: '{{ number_format($product->price, 2) }}', stock: 0, variants: {{ $variants->map(fn($v) => ['id' => $v->id, 'price' => $v->price, 'stock' => $v->stock, 'name' => $v->getDisplayName()])->values()->toJson() }} }">
                            <div>
                                <label for="product-variant" class="block text-sm font-medium text-brand-black">{{ __('Variant') }}</label>
                                <select id="product-variant" name="product_variant_id" class="mt-1 block w-full max-w-xs rounded-xl border border-slate-300 bg-white px-3 py-2 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20"
                                        x-model="variantId"
                                        @@change="variant = $event.target.value ? variants.find(i => i.id == parseInt($event.target.value)) : null; if(variant) { price = Number(variant.price).toFixed(2); stock = variant.stock; document.getElementById('product-price').textContent = price + ' {{ __('SAR') }}'; document.getElementById('variant-stock').textContent = variant.stock > 0 ? '{{ __('In stock') }}: ' + variant.stock : '{{ __('Out of stock') }}'; document.getElementById('variant-stock').previousElementSibling.className = 'material-icons ' + (variant.stock > 0 ? 'text-brand-teal' : 'text-amber-600'); } else { document.getElementById('variant-stock').textContent = '{{ __('Select a variant') }}'; document.getElementById('variant-stock').previousElementSibling.className = 'material-icons text-slate-400'; }">
                                    <option value="">{{ __('Select option') }}</option>
                                    @foreach($variants as $v)
                                        <option value="{{ $v->id }}" data-stock="{{ $v->stock }}">{{ $v->getDisplayName() }} — {{ number_format($v->price, 2) }} {{ __('SAR') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-brand-white px-4 py-3" id="variant-stock-wrap">
                                <span class="material-icons text-slate-400">inventory_2</span>
                                <span class="text-sm text-slate-500" id="variant-stock">{{ __('Select a variant') }}</span>
                            </div>
                            <form action="{{ route('cart.store') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_variant_id" :value="variantId">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-teal px-8 py-4 font-semibold text-white shadow-lg transition hover:bg-brand-teal-dark disabled:opacity-50 disabled:pointer-events-none" :disabled="!variantId || (variant && variant.stock < 1)">
                                    <span class="material-icons">shopping_cart</span>
                                    {{ __('Add to Cart') }}
                                </button>
                            </form>
                        </div>
                        @endif

                        {{-- Actions (no variants) --}}
                        @if(!$hasVariants)
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
                        @endif

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
                    @php
                        $ratingCounts = $product->reviews->groupBy('rating')->map->count();
                        $maxCount = $ratingCounts->max() ?: 1;
                    @endphp
                    <div class="mt-14 rounded-2xl border border-slate-200 bg-brand-white p-6 md:p-8">
                        <h2 class="text-xl font-bold text-brand-black">{{ __('Reviews') }} ({{ $product->reviews->count() }})</h2>
                        {{-- Star breakdown --}}
                        <div class="mt-4 flex flex-wrap items-center gap-6 rounded-xl bg-slate-50/80 p-4">
                            @for($stars = 5; $stars >= 1; $stars--)
                                @php $count = $ratingCounts->get($stars, 0); @endphp
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-slate-600">{{ $stars }} {{ __('stars') }}</span>
                                    <div class="h-2 w-24 overflow-hidden rounded-full bg-slate-200">
                                        <div class="h-full rounded-full bg-amber-500" style="width: {{ ($count / $maxCount) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm text-slate-500">{{ $count }}</span>
                                </div>
                            @endfor
                        </div>
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
                                                @if($review->isVerifiedPurchase())
                                                    <span class="inline-flex items-center gap-0.5 rounded bg-green-100 px-1.5 py-0.5 text-xs font-medium text-green-800" title="{{ __('Verified purchase') }}">
                                                        <span class="material-icons text-sm">verified</span> {{ __('Verified purchase') }}
                                                    </span>
                                                @endif
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

                {{-- You may also like (related) --}}
                @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
                    <div class="mt-14 rounded-2xl border border-slate-200 bg-brand-white p-6 md:p-8">
                        <h2 class="text-xl font-bold text-brand-black">{{ __('You may also like') }}</h2>
                        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                            @foreach($relatedProducts as $related)
                                <x-frontend.product-card :product="$related" />
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Recently viewed --}}
                @if(isset($recentlyViewed) && $recentlyViewed->isNotEmpty())
                    <div class="mt-14 rounded-2xl border border-slate-200 bg-brand-white p-6 md:p-8">
                        <h2 class="text-xl font-bold text-brand-black">{{ __('Recently viewed') }}</h2>
                        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
                            @foreach($recentlyViewed as $recent)
                                <x-frontend.product-card :product="$recent" />
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
