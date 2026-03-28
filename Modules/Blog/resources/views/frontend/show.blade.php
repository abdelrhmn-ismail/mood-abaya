@extends('frontend.layouts.app')

@section('title', ($post->meta_title ?: $post->title) . ' – ' . site_title())
@section('description', $post->meta_description ?: Str::limit(strip_tags($post->excerpt ?? $post->body ?? ''), 160))

@section('content')
    <section class="bg-slate-50 py-8 md:py-12">
        <div class="container mx-auto max-w-3xl px-4">
            <nav class="mb-6 flex flex-wrap items-center gap-1 text-sm text-brand-black/70" aria-label="{{ __('Breadcrumb') }}">
                <a href="{{ route('home') }}" class="transition hover:text-brand-teal">{{ site_label('nav_home') }}</a>
                <span class="material-icons text-base text-brand-black/40">chevron_right</span>
                <a href="{{ route('blog.index') }}" class="transition hover:text-brand-teal">{{ __('Blog') }}</a>
                <span class="material-icons text-base text-brand-black/40">chevron_right</span>
                <span class="font-medium text-brand-black">{{ $post->title }}</span>
            </nav>

            <article class="rounded-2xl border border-slate-200 bg-brand-white shadow-sm">
                @if($post->image)
                    <div class="aspect-video w-full overflow-hidden rounded-t-2xl">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="h-full w-full object-cover" loading="lazy">
                    </div>
                @endif
                <div class="p-6 md:p-8">
                    <time class="text-sm text-slate-500" datetime="{{ $post->published_at?->toIso8601String() }}">{{ $post->published_at?->format('d F Y') }}</time>
                    <h1 class="mt-2 text-2xl font-bold text-brand-black md:text-3xl">{{ $post->title }}</h1>
                    @if($post->excerpt)
                        <p class="mt-3 text-lg text-brand-black/80">{{ $post->excerpt }}</p>
                    @endif
                    <div class="mt-6 prose prose-slate max-w-none prose-headings:text-brand-black prose-a:text-brand-teal">
                        {!! safe_html($post->body ?? '') !!}
                    </div>
                </div>
            </article>

            <p class="mt-6">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1 text-brand-teal transition hover:text-brand-teal-dark">
                    <span class="material-icons">arrow_back</span>
                    {{ __('Back to Blog') }}
                </a>
            </p>
        </div>
    </section>
@endsection
