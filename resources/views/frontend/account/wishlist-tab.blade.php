{{-- Wishlist tab: list of saved products --}}
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
    @endif
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-slate-900">{{ __('My Wishlist') }}</h2>
        <p class="text-sm text-slate-600">{{ count($wishlistItems ?? []) }} {{ count($wishlistItems ?? []) === 1 ? __('item') : __('items') }}</p>
    </div>

    @if(isset($wishlistItems) && $wishlistItems->isNotEmpty())
        <ul class="grid grid-cols-1 gap-0 divide-y divide-slate-200">
            @foreach($wishlistItems as $item)
                @php $product = $item->product; @endphp
                @if($product)
                    <li class="flex flex-col gap-4 py-4 sm:flex-row sm:items-center sm:gap-6">
                        <a href="{{ route('products.show', $product->slug) }}" class="h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-slate-100 sm:h-24 sm:w-24">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                            @else
                                <span class="flex h-full w-full items-center justify-center text-slate-400">
                                    <span class="material-icons text-4xl">inventory_2</span>
                                </span>
                            @endif
                        </a>
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('products.show', $product->slug) }}" class="font-semibold text-slate-900 hover:underline">{{ $product->name }}</a>
                            @if($product->category)
                                <p class="mt-0.5 text-sm text-slate-500">{{ $product->category->name }}</p>
                            @endif
                            <p class="mt-1 text-lg font-bold text-slate-800">{{ number_format($product->price, 2) }} {{ __('SAR') }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2 shrink-0">
                            <a href="{{ route('products.show', $product->slug) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                {{ __('View') }}
                            </a>
                            <form action="{{ route('wishlist.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Remove from wishlist?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-red-100 bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700 transition hover:bg-red-100">
                                    <span class="material-icons text-lg">favorite</span>
                                    {{ __('Remove') }}
                                </button>
                            </form>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    @else
        <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-12 text-center">
            <span class="material-icons text-6xl text-slate-300">favorite_border</span>
            <p class="mt-4 font-medium text-slate-700">{{ __('Your wishlist is empty') }}</p>
            <p class="mt-1 text-sm text-slate-500">{{ __('Save items you like by clicking the heart on product pages.') }}</p>
            <a href="{{ route('categories') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-teal px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-teal-dark">
                {{ __('Browse categories') }}
            </a>
        </div>
    @endif
</div>
