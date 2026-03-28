@props(['product', 'showAddToCart' => true])

@php
    $cardImages = $product->getDisplayImages();
@endphp
<article class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-brand-white shadow-sm transition hover:shadow-xl hover:border-brand-teal/20" x-data="{ active: 0 }">
    <div class="absolute right-2 top-2 z-20 flex gap-1 product-card-actions" onclick="event.preventDefault(); event.stopPropagation();">
        @include('frontend.partials.wishlist-button', ['product' => $product])
    </div>
    <a href="{{ route('products.show', $product->slug) }}" class="flex flex-col flex-1 min-h-0">
        @if($cardImages->isEmpty())
            <div class="aspect-square w-full shrink-0 flex items-center justify-center bg-slate-100">
                <span class="material-icons text-6xl text-slate-300">inventory_2</span>
            </div>
        @else
            <div class="relative aspect-square w-full shrink-0 overflow-hidden bg-slate-100">
                @foreach($cardImages as $index => $item)
                    <img src="{{ get_image_url($item->image) }}" alt="{{ $product->name }}"
                         class="absolute inset-0 h-full w-full object-cover transition duration-300 group-hover:scale-105 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                         :class="active === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'"
                         loading="lazy">
                @endforeach
                @if($cardImages->count() > 1)
                    <div class="absolute bottom-2 left-0 right-0 z-20 flex justify-center gap-1.5" onclick="event.preventDefault(); event.stopPropagation();">
                        @foreach($cardImages as $index => $item)
                            <button type="button" class="h-1.5 w-1.5 rounded-full transition focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2"
                                    :class="active === {{ $index }} ? 'bg-brand-teal scale-125' : 'bg-white/80 hover:bg-white'"
                                    @click.prevent="active = {{ $index }}"
                                    aria-label="{{ __('Image') }} {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
        <div class="border-t border-slate-100 flex min-h-[7.5rem] flex-col p-5 transition group-hover:bg-brand-gold/5">
            @if($product->hasDiscount())
                <span class="inline-flex w-fit items-center gap-1 self-start rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-800">
                    <span class="material-icons text-lg">local_offer</span> {{ __('Save') }} {{ $product->discountPercent() }}%
                </span>
            @else
                <span class="inline-block h-5" aria-hidden="true"></span>
            @endif
            <h2 class="mt-1 font-semibold text-brand-black group-hover:text-brand-teal line-clamp-2">{{ $product->name }}</h2>
            <div class="mt-2 flex flex-wrap items-baseline gap-1.5">
                <span class="text-lg font-bold text-brand-teal">{{ number_format($product->price, 2) }} {{ __('SAR') }}</span>
                @if($product->hasDiscount())
                    <span class="text-sm text-slate-500 line-through">{{ number_format($product->compare_at_price, 2) }} {{ __('SAR') }}</span>
                @endif
            </div>
        </div>
    </a>
    @if($showAddToCart)
        @php
            $inCart = app(\Modules\Cart\Services\CartService::class)->hasInCart($product->id, null);
        @endphp
        <div class="mt-auto shrink-0 border-t border-slate-100 p-4">
            <form action="{{ route('cart.store') }}" method="POST" data-ajax-cart data-in-cart="{{ $inCart ? '1' : '0' }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand-teal py-3 text-sm font-semibold text-white transition hover:bg-brand-teal-dark disabled:opacity-70 disabled:cursor-not-allowed" data-ripple-light="true" data-added-label="{{ __('In cart') }}" @if($inCart) disabled @endif>
                    <span class="cart-btn-text">{{ $inCart ? __('In cart') : __('Add to Cart') }}</span>
                </button>
            </form>
        </div>
    @endif
</article>
