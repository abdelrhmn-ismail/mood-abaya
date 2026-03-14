@extends('frontend.layouts.app')

@section('title', __($page->page_name) . ' – ' . config('app.name'))
@section('description', __($page->page_name))

@section('content')
    <x-frontend.hero-header :title="__($page->page_name)" :subtitle="null" setting="hero_page" />

    <section class="bg-white py-16 md:py-20">
        <div class="container mx-auto max-w-3xl px-4">
            <div class="mt-8 prose prose-slate max-w-none text-slate-700">
                @if($content)
                    {!! safe_html($content) !!}
                @else
                    <p class="text-slate-500">{{ __('No content yet.') }}</p>
                @endif
            </div>
        </div>
    </section>
@endsection
