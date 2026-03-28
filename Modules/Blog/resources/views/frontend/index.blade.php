@extends('frontend.layouts.app')

@section('title', __('Blog') . ' – ' . site_title())
@section('description', __('News and updates from') . ' ' . site_title())

@section('content')
    <x-frontend.hero-header :title="__('Blog')" :subtitle="__('News and announcements')" setting="hero_page" />

    <section class="bg-slate-50 py-12 md:py-16">
        <div class="container mx-auto px-4">
            @if($posts->isEmpty())
                <p class="text-center text-brand-black/70">{{ __('No posts yet.') }}</p>
            @else
                <div class="mx-auto grid max-w-6xl gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($posts as $post)
                        <article class="flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-brand-white shadow-sm transition hover:shadow-lg">
                            <a href="{{ route('blog.show', $post->slug) }}" class="block aspect-video w-full overflow-hidden bg-slate-100">
                                @if($post->image)
                                    <img src="{{ get_image_url($post->image) }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition duration-300 hover:scale-105" loading="lazy">
                                @else
                                    <span class="flex h-full w-full items-center justify-center text-slate-300">
                                        <span class="material-icons text-6xl">article</span>
                                    </span>
                                @endif
                            </a>
                            <div class="flex flex-1 flex-col p-5">
                                <time class="text-sm text-slate-500" datetime="{{ $post->published_at?->toIso8601String() }}">{{ $post->published_at?->format('d M Y') }}</time>
                                <h2 class="mt-2 font-semibold text-brand-black line-clamp-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="transition hover:text-brand-teal">{{ $post->title }}</a>
                                </h2>
                                @if($post->excerpt)
                                    <p class="mt-2 flex-1 text-sm text-brand-black/70 line-clamp-3">{{ $post->excerpt }}</p>
                                @endif
                                <a href="{{ route('blog.show', $post->slug) }}" class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-brand-teal transition hover:text-brand-teal-dark">
                                    {{ __('Read more') }}
                                    <span class="material-icons text-lg">arrow_forward</span>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
                @if($posts->hasPages())
                    <div class="mt-10 flex justify-center">{{ $posts->links() }}</div>
                @endif
            @endif
        </div>
    </section>
@endsection
