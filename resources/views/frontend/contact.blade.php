@extends('frontend.layouts.app')

@section('title', __('Contact Us') . ' – ' . config('app.name'))
@section('description', __('Contact Us'))

@section('content')
    <x-frontend.hero-header :title="__('Contact Us')" :subtitle="__('We would love to hear from you.')" setting="hero_contact" />

    <section class="bg-white py-16 md:py-20">
        <div class="container mx-auto max-w-2xl px-4">

            @if(session('success'))
                <div class="mt-6 rounded-xl bg-green-100 px-4 py-3 text-green-800" role="alert">{{ session('success') }}</div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST" class="mt-10 space-y-6 rounded-2xl border border-slate-200 bg-slate-50/50 p-8">
                @csrf
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">{{ __('Your Name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="255" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">{{ __('Your Email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="subject" class="mb-2 block text-sm font-medium text-slate-700">{{ __('Subject') }}</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" maxlength="255" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                    @error('subject')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="message" class="mb-2 block text-sm font-medium text-slate-700">{{ __('Message') }}</label>
                    <textarea name="message" id="message" rows="5" required maxlength="10000" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full rounded-xl bg-slate-900 py-3.5 font-semibold text-white transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 sm:w-auto sm:px-8">
                    {{ __('Send Message') }}
                </button>
            </form>
        </div>
    </section>
@endsection
