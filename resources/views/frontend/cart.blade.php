@extends('frontend.layouts.app')

@section('title', __('Cart') . ' – ' . config('app.name'))
@section('description', __('Your shopping cart'))

@section('content')
    <x-frontend.hero-header :title="__('Cart')" :subtitle="__('Review your items and proceed to checkout')" setting="hero_cart" />

    <section class="bg-white py-16 md:py-20">
        <div class="container mx-auto max-w-4xl px-4">
            @if(session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            @if($items->isEmpty())
                {{-- Empty cart state --}}
                <div class="mx-auto max-w-md rounded-2xl border border-slate-200 bg-slate-50/50 p-10 text-center shadow-sm">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-200/80 text-slate-500">
                        <span class="material-icons text-5xl">shopping_cart</span>
                    </div>
                    <h2 class="mt-6 text-xl font-semibold text-slate-900">{{ __('Your cart is empty') }}</h2>
                    <p class="mt-2 text-slate-600">{{ __('Your cart is empty.') }} {{ __('Add items from our shop to get started.') }}</p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                        <a href="{{ route('categories') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-teal px-6 py-3.5 font-semibold text-white shadow-sm transition hover:bg-brand-teal-dark">
                            <span class="material-icons text-xl">storefront</span>
                            {{ __('Continue Shopping') }}
                        </a>
                        <a href="{{ route('home') }}#products" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-6 py-3.5 font-medium text-slate-700 transition hover:bg-slate-50">
                            {{ __('View All Products') }}
                        </a>
                    </div>
                </div>
            @else
                {{-- Cart with items --}}
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <ul class="divide-y divide-slate-100">
                        @foreach($items as $item)
                            <li class="flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:gap-6">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="shrink-0">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-28 w-28 rounded-xl object-cover shadow-sm transition hover:shadow">
                                    @else
                                        <div class="flex h-28 w-28 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                                            <span class="material-icons text-5xl">inventory_2</span>
                                        </div>
                                    @endif
                                </a>
                                <div class="min-w-0 flex-1">
                                    <a href="{{ route('products.show', $item->product->slug) }}" class="font-semibold text-slate-900 hover:underline">
                                        {{ $item->product->name }}
                                    </a>
                                    <p class="mt-1 text-slate-600">{{ number_format($item->product->price, 2) }} {{ __('SAR') }} {{ __('each') }}</p>
                                </div>
                                <div class="flex flex-wrap items-center gap-4 sm:gap-6">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <label for="qty-{{ $item->id }}" class="sr-only">{{ __('Quantity') }}</label>
                                        <input type="number" name="quantity" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="999" class="w-20 rounded-xl border border-slate-300 bg-white px-2 py-2.5 text-center text-slate-900 shadow-sm focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                                        <button type="submit" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ __('Update') }}</button>
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
                    <div class="flex flex-col gap-4 border-t border-slate-200 bg-slate-50/50 p-6 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xl font-bold text-slate-900">{{ __('Total') }}: {{ number_format($total, 2) }} {{ __('SAR') }}</p>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('categories') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-2.5 font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                                {{ __('Continue Shopping') }}
                            </a>
                            <a href="{{ route('checkout') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-teal px-6 py-2.5 font-semibold text-white shadow-sm transition hover:bg-brand-teal-dark">
                                <span class="material-icons text-lg">shopping_bag</span>
                                {{ __('Proceed to Checkout') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
