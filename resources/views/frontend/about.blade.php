@extends('frontend.layouts.app')

@section('title', __('About Us') . ' – ' . config('app.name'))
@section('description', __('About Us'))

@section('content')
    <section class="bg-white py-20 md:py-24">
        <div class="container mx-auto max-w-3xl px-4">
            <h1 class="text-4xl font-bold text-slate-900 md:text-5xl">{{ __('About Us') }}</h1>
            <p class="mt-6 text-lg leading-relaxed text-slate-600">
                {{ __('Quality products for everyone. Shop with confidence.') }}
            </p>
            <div class="mt-10 rounded-2xl border border-slate-200 bg-slate-50 p-8">
                <p class="text-slate-700">
                    {{ __('This is the about page. Content can be updated later.') }}
                </p>
            </div>
        </div>
    </section>
@endsection
