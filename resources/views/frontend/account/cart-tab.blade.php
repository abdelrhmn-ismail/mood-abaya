{{-- Cart tab: list of cart items (full-width rows, same style as wishlist) --}}
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
    @endif
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-slate-900">{{ __('My Cart') }}</h2>
        <p class="text-sm text-slate-600">
            {{ count($cartItems ?? []) }} {{ count($cartItems ?? []) === 1 ? __('item') : __('items') }}
            @if(isset($cartTotal) && $cartTotal > 0)
                · {{ __('Total') }}: {{ number_format($cartTotal, 2) }} {{ __('SAR') }}
            @endif
        </p>
    </div>

    @if(isset($cartItems) && $cartItems->isNotEmpty())
        <ul class="grid grid-cols-1 gap-0 divide-y divide-slate-200">
            @foreach($cartItems as $item)
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
                            <p class="mt-0.5 text-sm text-slate-500">{{ number_format($product->price, 2) }} {{ __('SAR') }} {{ __('each') }}</p>
                            <p class="mt-1 font-semibold text-slate-800">{{ __('Qty') }}: {{ $item->quantity }} · {{ number_format($product->price * $item->quantity, 2) }} {{ __('SAR') }}</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 shrink-0">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="999" class="w-16 rounded-lg border border-slate-300 px-2 py-1.5 text-center text-sm text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                                <button type="submit" class="rounded-lg px-2 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ __('Update') }}</button>
                            </form>
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Remove this item?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg p-2 text-red-600 hover:bg-red-50" aria-label="{{ __('Remove') }}">
                                    <span class="material-icons text-xl">delete</span>
                                </button>
                            </form>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
        <div class="flex flex-col gap-4 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-xl font-bold text-slate-900">{{ __('Total') }}: {{ number_format($cartTotal ?? 0, 2) }} {{ __('SAR') }}</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('categories') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-2.5 font-medium text-slate-700 transition hover:bg-slate-50">
                    {{ __('Continue Shopping') }}
                </a>
                <a href="{{ route('checkout') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-teal px-6 py-2.5 font-semibold text-white transition hover:bg-brand-teal-dark">
                    {{ __('Checkout') }}
                </a>
            </div>
        </div>
    @else
        <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-12 text-center">
            <span class="material-icons text-6xl text-slate-300">shopping_cart</span>
            <p class="mt-4 font-medium text-slate-700">{{ __('Your cart is empty') }}</p>
            <p class="mt-1 text-sm text-slate-500">{{ __('Add items from the shop to see them here.') }}</p>
            <a href="{{ route('categories') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-teal px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-teal-dark">
                {{ __('Browse categories') }}
            </a>
        </div>
    @endif
</div>
