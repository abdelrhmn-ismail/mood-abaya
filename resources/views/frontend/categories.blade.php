@extends('frontend.layouts.app')

@section('title', __('Categories') . ' – ' . config('app.name'))
@section('description', __('Shop by Category'))

@section('content')
    <section class="bg-white py-20 md:py-24">
        <div class="container mx-auto px-4">
            <h1 class="text-center text-4xl font-bold text-slate-900 md:text-5xl">{{ __('Shop by Category') }}</h1>
            <p class="mx-auto mt-3 max-w-2xl text-center text-slate-600">{{ __('Browse our collections') }}</p>
            <div class="mx-auto mt-12 grid max-w-5xl grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-xl">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-48 w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="flex h-48 w-full items-center justify-center bg-gradient-to-br from-slate-100 to-slate-50">
                                <span class="material-icons text-6xl text-slate-300">category</span>
                            </div>
                        @endif
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-slate-900">{{ $category->name }}</h2>
                            @if($category->description)
                                <p class="mt-2 line-clamp-2 text-sm text-slate-600">{{ $category->description }}</p>
                            @endif
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-slate-600">{{ __('No categories yet.') }}</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
