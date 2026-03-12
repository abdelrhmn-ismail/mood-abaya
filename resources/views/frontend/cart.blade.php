@extends('frontend.layouts.app')

@section('title', __('Cart') . ' – ' . config('app.name'))
@section('description', __('Cart'))

@section('content')
    <section class="py-16 md:py-20">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-3xl font-bold mb-8 text-gray-900">{{ __('Cart') }}</h1>

            @if(session('success'))
                <div class="mb-6 rounded-lg bg-green-100 text-green-800 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @if($items->isEmpty())
                <p class="text-gray-600 mb-6">{{ __('Your cart is empty.') }}</p>
                <a href="{{ route('categories') }}" class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-6 py-2.5 font-medium text-white hover:bg-gray-800">
                    {{ __('Continue Shopping') }}
                </a>
                @php return @endphp
            @endif

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <ul class="divide-y divide-gray-200">
                    @foreach($items as $item)
                        <li class="flex flex-col gap-4 p-4 sm:flex-row sm:items-center sm:gap-6">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-24 w-24 rounded-lg object-cover">
                            @else
                                <div class="flex h-24 w-24 items-center justify-center rounded-lg bg-gray-100">
                                    <span class="material-icons text-4xl text-gray-400">inventory_2</span>
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="font-medium text-gray-900 hover:underline">
                                    {{ $item->product->name }}
                                </a>
                                <p class="text-gray-600">{{ number_format($item->product->price, 2) }} {{ __('SAR') }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <label for="qty-{{ $item->id }}" class="sr-only">{{ __('Quantity') }}</label>
                                    <input type="number" name="quantity" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="999"
                                           class="w-20 rounded-lg border border-gray-300 bg-white px-2 py-1.5 text-center text-gray-900">
                                    <button type="submit" class="text-sm text-blue-600 hover:underline">{{ __('Update') }}</button>
                                </form>
                                <p class="font-semibold text-gray-900">{{ number_format($item->product->price * $item->quantity, 2) }} {{ __('SAR') }}</p>
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST" onsubmit="return confirm('{{ __('Remove this item?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded p-1.5 text-red-600 hover:bg-red-50" aria-label="{{ __('Remove') }}">
                                        <span class="material-icons text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="flex flex-col gap-4 border-t border-gray-200 p-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xl font-bold text-gray-900">{{ __('Total') }}: {{ number_format($total, 2) }} {{ __('SAR') }}</p>
                    <div class="flex gap-3">
                        <a href="{{ route('categories') }}" class="rounded-lg border border-gray-300 px-4 py-2 font-medium text-gray-700 hover:bg-gray-50">
                            {{ __('Continue Shopping') }}
                        </a>
                        <a href="{{ route('checkout') }}" class="rounded-lg bg-blue-600 px-6 py-2 font-medium text-white hover:bg-blue-700">
                            {{ __('Proceed to Checkout') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
