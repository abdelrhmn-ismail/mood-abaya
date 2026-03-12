@extends('frontend.layouts.app')

@section('title', $category->name . ' – ' . config('app.name'))
@section('description', $category->description ?? $category->name)

@section('content')
    <section class="py-16 md:py-20">
        <div class="container mx-auto px-4">
            <nav class="mb-8 text-sm text-gray-600">
                <a href="{{ route('categories') }}" class="hover:text-gray-900">{{ __('Categories') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $category->name }}</span>
            </nav>
            <h1 class="text-3xl font-bold mb-10">{{ $category->name }}</h1>
            @if($category->description)
                <p class="mb-10 text-gray-600 max-w-2xl">{{ $category->description }}</p>
            @endif
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse($products as $product)
                    <a href="{{ route('products.show', $product->slug) }}"
                       class="group flex flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                 class="h-48 w-full object-cover transition group-hover:scale-105">
                        @else
                            <div class="flex h-48 w-full items-center justify-center bg-gray-100">
                                <span class="material-icons text-6xl text-gray-400">inventory_2</span>
                            </div>
                        @endif
                        <div class="flex flex-1 flex-col p-4">
                            <h2 class="font-semibold text-gray-900">{{ $product->name }}</h2>
                            <p class="mt-2 text-lg font-medium text-gray-900">{{ number_format($product->price, 2) }} {{ __('SAR') }}</p>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-gray-600">{{ __('No products in this category.') }}</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
