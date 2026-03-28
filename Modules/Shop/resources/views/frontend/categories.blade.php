@extends('frontend.layouts.app')

@section('title', __('Categories') . ' – ' . site_title())
@section('description', __('Shop by Category'))

@section('content')
    <x-frontend.hero-header :title="__('Shop by Category')" :subtitle="__('Browse our collections')" setting="hero_categories" />

    <section class="bg-slate-50 py-16 md:py-20">
        <div class="container mx-auto px-4">
            <div class="mx-auto mt-6 grid max-w-5xl grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="group overflow-hidden rounded-2xl border border-slate-200 bg-brand-white shadow-sm transition hover:shadow-xl hover:border-brand-teal/30">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-48 w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="flex h-48 w-full items-center justify-center bg-gradient-to-br from-brand-teal/10 to-brand-gold/10">
                                <span class="material-icons text-6xl text-brand-teal/50">category</span>
                            </div>
                        @endif
                        <div class="border-t border-slate-100 p-6 transition group-hover:bg-brand-gold/5">
                            <h2 class="text-xl font-semibold text-brand-black group-hover:text-brand-teal">{{ $category->name }}</h2>
                            @if($category->description)
                                <p class="mt-2 line-clamp-2 text-sm text-brand-black/70">{{ strip_tags($category->description) }}</p>
                            @endif
                        </div>
                    </a>
                @empty
                    <p class="col-span-full py-12 text-center text-brand-black/70">{{ __('No categories yet.') }}</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
