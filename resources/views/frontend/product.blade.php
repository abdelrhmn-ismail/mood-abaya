@extends('frontend.layouts.app')

@section('title', $product->name . ' – ' . config('app.name'))
@section('description', Str::limit($product->description, 160))

@section('content')
    <section class="bg-white py-12 md:py-16">
        <div class="container mx-auto px-4">
            <nav class="mb-8 text-sm text-slate-600">
                <a href="{{ route('categories') }}" class="hover:text-slate-900">{{ __('Categories') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('categories.show', $product->category->slug) }}" class="hover:text-slate-900">{{ $product->category->name }}</a>
                <span class="mx-2">/</span>
                <span class="font-medium text-slate-900">{{ $product->name }}</span>
            </nav>
            <div class="mx-auto max-w-5xl">
                <div class="grid gap-10 md:grid-cols-2">
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex aspect-square items-center justify-center">
                                <span class="material-icons text-8xl text-slate-300">inventory_2</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 md:text-4xl">{{ $product->name }}</h1>
                        <p class="mt-4 text-2xl font-bold text-slate-800">{{ number_format($product->price, 2) }} {{ __('SAR') }}</p>
                        @if($product->description)
                            <div class="mt-6 text-slate-600 prose prose-slate max-w-none">{{ nl2br(e($product->description)) }}</div>
                        @endif
                        <p class="mt-6 text-sm text-slate-500">
                            @if($product->stock > 0)
                                {{ __('In stock') }}: {{ $product->stock }}
                            @else
                                <span class="font-medium text-amber-600">{{ __('Out of stock') }}</span>
                            @endif
                        </p>
                        <div class="mt-8">
                            <form action="{{ route('cart.store') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-8 py-3.5 font-semibold text-white transition hover:bg-slate-800 disabled:opacity-50 disabled:pointer-events-none" @if($product->stock < 1) disabled @endif>
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
