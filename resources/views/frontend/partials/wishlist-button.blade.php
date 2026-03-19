@php
    $inWishlist = app(\Modules\Shop\Services\WishlistService::class)->has($product->id);
@endphp
<div class="inline rounded-full bg-white/90 shadow-sm" data-wishlist-wrap data-ajax-wishlist data-product-id="{{ $product->id }}" data-in-wishlist="{{ $inWishlist ? '1' : '0' }}" onclick="event.stopPropagation();">
    <form action="{{ route('wishlist.destroy', $product->id) }}" method="POST" class="inline" data-wishlist-action="remove" title="{{ __('Remove from wishlist') }}" style="{{ $inWishlist ? '' : 'display:none' }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="inline-flex items-center justify-center rounded-full p-2 text-red-500 transition hover:bg-red-50 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" aria-label="{{ __('Remove from wishlist') }}">
            <span class="material-icons text-2xl wishlist-icon">favorite</span>
        </button>
    </form>
    <form action="{{ route('wishlist.store') }}" method="POST" class="inline" data-wishlist-action="add" title="{{ __('Add to wishlist') }}" style="{{ $inWishlist ? 'display:none' : '' }}">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <button type="submit" class="inline-flex items-center justify-center rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2" aria-label="{{ __('Add to wishlist') }}">
            <span class="material-icons text-2xl wishlist-icon-border">favorite_border</span>
        </button>
    </form>
</div>
