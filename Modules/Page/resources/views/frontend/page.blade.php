@extends('frontend.layouts.app')

@section('title', __($page->page_name) . ' – ' . site_title())
@section('description', __($page->page_name))

@section('content')
    <x-frontend.hero-header :title="__($page->page_name)" :subtitle="null" setting="hero_page" />

    <section class="bg-slate-50 py-16 md:py-20">
        <div class="container mx-auto max-w-3xl px-4">
            <div class="mt-8 prose prose-slate max-w-none prose-headings:text-brand-black prose-p:text-brand-black/80 prose-li:text-brand-black/80 prose-a:text-brand-teal">
                @if($content)
                    {!! safe_html($content) !!}
                @else
                    <p class="text-brand-black/60">{{ __('No content yet.') }}</p>
                @endif
            </div>
        </div>
    </section>
@endsection
