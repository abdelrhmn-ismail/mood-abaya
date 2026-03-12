@extends('frontend.layouts.app')

@section('title', __('About Us') . ' – ' . config('app.name'))
@section('description', __('About Us'))

@section('content')
    <section class="py-16 md:py-20">
        <div class="container mx-auto px-4 max-w-3xl">
            <h1 class="text-3xl font-bold mb-6">{{ __('About Us') }}</h1>
            <p class="text-gray-600 mb-4">
                {{ __('Quality products for everyone. Shop with confidence.') }}
            </p>
            <p class="text-gray-600">
                This is the about page. Content can be updated later.
            </p>
        </div>
    </section>
@endsection
