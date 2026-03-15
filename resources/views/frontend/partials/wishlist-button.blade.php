@php
    $inWishlist = auth()->check() && \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
@endphp
@auth
    @if($inWishlist)
        <form action="{{ route('wishlist.destroy', $product->id) }}" method="POST" class="inline" title="{{ __('Remove from wishlist') }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center justify-center rounded-full p-2 text-red-500 transition hover:bg-red-50 hover:text-red-600" aria-label="{{ __('Remove from wishlist') }}">
                <span class="material-icons text-2xl">favorite</span>
            </button>
        </form>
    @else
        <form action="{{ route('wishlist.store') }}" method="POST" class="inline" title="{{ __('Add to wishlist') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="inline-flex items-center justify-center rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-red-500" aria-label="{{ __('Add to wishlist') }}">
                <span class="material-icons text-2xl">favorite_border</span>
            </button>
        </form>
    @endif
@else
    <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="inline-flex items-center justify-center rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-red-500" title="{{ __('Login to save to wishlist') }}" aria-label="{{ __('Add to wishlist') }}">
        <span class="material-icons text-2xl">favorite_border</span>
    </a>
@endauth
