@extends('frontend.layouts.app')

@section('title', __('Categories') . ' – ' . config('app.name'))
@section('description', __('Shop by Category'))

@section('content')
    <section class="py-16 md:py-20">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-10 text-center">{{ __('Shop by Category') }}</h1>
            <div class="mx-auto grid max-w-5xl grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($categories ?? [] as $category)
                    <a href="{{ route('categories.show', $category->slug) }}"
                       class="group flex flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                 class="h-40 w-full object-cover transition group-hover:scale-105">
                        @else
                            <div class="flex h-40 w-full items-center justify-center bg-gray-100">
                                <span class="material-icons text-5xl text-gray-400">category</span>
                            </div>
                        @endif
                        <div class="flex flex-1 flex-col p-4">
                            <h2 class="font-semibold text-gray-900">{{ $category->name }}</h2>
                            @if($category->description)
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $category->description }}</p>
                            @endif
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-gray-600">{{ __('No categories yet.') }}</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
