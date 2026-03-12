@extends('frontend.layouts.app')

@section('title', $product->name . ' – ' . config('app.name'))
@section('description', Str::limit($product->description, 160))

@section('content')
    <section class="py-16 md:py-20">
        <div class="container mx-auto px-4">
            <nav class="mb-8 text-sm text-gray-600">
                <a href="{{ route('categories') }}" class="hover:text-gray-900">{{ __('Categories') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('categories.show', $product->category->slug) }}" class="hover:text-gray-900">{{ $product->category->name }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $product->name }}</span>
            </nav>
            <div class="mx-auto max-w-5xl">
                <div class="grid gap-10 md:grid-cols-2">
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                 class="h-full w-full object-cover">
                        @else
                            <div class="flex aspect-square items-center justify-center">
                                <span class="material-icons text-8xl text-gray-400">inventory_2</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                        <p class="mt-4 text-2xl font-semibold text-gray-900">{{ number_format($product->price, 2) }} {{ __('SAR') }}</p>
                        @if($product->description)
                            <div class="mt-6 text-gray-600 prose max-w-none">
                                {{ nl2br(e($product->description)) }}
                            </div>
                        @endif
                        <p class="mt-4 text-sm text-gray-500">
                            @if($product->stock > 0)
                                {{ __('In stock') }}: {{ $product->stock }}
                            @else
                                <span class="text-amber-600">{{ __('Out of stock') }}</span>
                            @endif
                        </p>
                        <div class="mt-8">
                            <form action="{{ route('cart.store') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-3 font-medium text-white transition hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                        @if($product->stock < 1) disabled @endif>
                                    <span class="material-icons">shopping_cart</span>
                                    {{ __('Add to Cart') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
