@extends('frontend.layouts.app')

@section('title', __('Cart') . ' – ' . config('app.name'))
@section('description', __('Cart'))

@section('content')
    <section class="bg-slate-50 py-16 md:py-20">
        <div class="container mx-auto max-w-4xl px-4">
            <h1 class="text-4xl font-bold text-slate-900">{{ __('Cart') }}</h1>

            @if(session('success'))
                <div class="mt-6 rounded-xl bg-green-100 px-4 py-3 text-green-800">{{ session('success') }}</div>
            @endif

            @if($items->isEmpty())
                <div class="mt-10 rounded-2xl border border-slate-200 bg-white p-12 text-center">
                    <p class="text-slate-600">{{ __('Your cart is empty.') }}</p>
                    <a href="{{ route('categories') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-6 py-3 font-semibold text-white hover:bg-slate-800">
                        {{ __('Continue Shopping') }}
                    </a>
                </div>
                @php return @endphp
            @endif

            <div class="mt-10 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <ul class="divide-y divide-slate-200">
                    @foreach($items as $item)
                        <li class="flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:gap-6">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-24 w-24 rounded-xl object-cover">
                            @else
                                <div class="flex h-24 w-24 items-center justify-center rounded-xl bg-slate-100">
                                    <span class="material-icons text-4xl text-slate-400">inventory_2</span>
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="font-semibold text-slate-900 hover:underline">
                                    {{ $item->product->name }}
                                </a>
                                <p class="text-slate-600">{{ number_format($item->product->price, 2) }} {{ __('SAR') }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <label for="qty-{{ $item->id }}" class="sr-only">{{ __('Quantity') }}</label>
                                    <input type="number" name="quantity" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="999" class="w-20 rounded-xl border border-slate-300 bg-white px-2 py-2 text-center text-slate-900">
                                    <button type="submit" class="text-sm font-medium text-slate-700 hover:underline">{{ __('Update') }}</button>
                                </form>
                                <p class="font-semibold text-slate-900">{{ number_format($item->product->price * $item->quantity, 2) }} {{ __('SAR') }}</p>
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST" onsubmit="return confirm('{{ __('Remove this item?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg p-2 text-red-600 hover:bg-red-50" aria-label="{{ __('Remove') }}">
                                        <span class="material-icons text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="flex flex-col gap-4 border-t border-slate-200 p-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xl font-bold text-slate-900">{{ __('Total') }}: {{ number_format($total, 2) }} {{ __('SAR') }}</p>
                    <div class="flex gap-3">
                        <a href="{{ route('categories') }}" class="rounded-xl border border-slate-300 px-5 py-2.5 font-medium text-slate-700 hover:bg-slate-50">
                            {{ __('Continue Shopping') }}
                        </a>
                        <a href="{{ route('checkout') }}" class="rounded-xl bg-slate-900 px-6 py-2.5 font-semibold text-white hover:bg-slate-800">
                            {{ __('Proceed to Checkout') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
