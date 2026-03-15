@props(['product', 'showAddToCart' => true])

<article class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-brand-white shadow-sm transition hover:shadow-xl hover:border-brand-teal/20">
    <div class="absolute right-2 top-2 z-10" onclick="event.preventDefault(); event.stopPropagation();">
        @include('frontend.partials.wishlist-button', ['product' => $product])
    </div>
    <a href="{{ route('products.show', $product->slug) }}" class="flex flex-col flex-1 min-h-0">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="aspect-square w-full shrink-0 object-cover transition duration-300 group-hover:scale-105" loading="lazy">
        @else
            <div class="aspect-square w-full shrink-0 flex items-center justify-center bg-slate-100">
                <span class="material-icons text-6xl text-slate-300">inventory_2</span>
            </div>
        @endif
        <div class="border-t border-slate-100 flex min-h-[7.5rem] flex-col p-5 transition group-hover:bg-brand-gold/5">
            @if($product->hasDiscount())
                <span class="inline-block rounded bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-800">{{ __('Save') }} {{ $product->discountPercent() }}%</span>
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
        <div class="mt-auto shrink-0 border-t border-slate-100 p-4">
            <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand-teal py-3 text-sm font-semibold text-white transition hover:bg-brand-teal-dark" data-ripple-light="true">
                    {{ __('Add to Cart') }}
                </button>
            </form>
        </div>
    @endif
</article>
