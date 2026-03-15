@extends('frontend.layouts.app')

@section('title', __('Contact Us') . ' – ' . config('app.name'))
@section('description', __('Contact Us'))

@section('content')
    <x-frontend.hero-header :title="__('Contact Us')" :subtitle="__('We would love to hear from you.')" setting="hero_contact" />

    <section class="bg-slate-50 py-16 md:py-20">
        <div class="container mx-auto max-w-2xl px-4">
            <p class="mb-2 text-center text-brand-black/80">
                {{ __('Have a question about your order or our collection? Send us a message and we will get back to you soon.') }}
            </p>

            @if(session('success'))
                <div class="mt-6 rounded-xl bg-green-100 px-4 py-3 text-green-800" role="alert">{{ session('success') }}</div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST" class="mt-10 space-y-6 rounded-2xl border border-slate-200 bg-brand-white p-8 shadow-sm">
                @csrf
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-brand-black">{{ __('Your Name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="255" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-brand-black">{{ __('Your Email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="subject" class="mb-2 block text-sm font-medium text-brand-black">{{ __('Subject') }}</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" maxlength="255" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                    @error('subject')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="message" class="mb-2 block text-sm font-medium text-brand-black">{{ __('Message') }}</label>
                    <textarea name="message" id="message" rows="5" required maxlength="10000" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-teal py-3.5 font-semibold text-white transition hover:bg-brand-teal-dark focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2 sm:w-auto sm:px-8">
                    {{ __('Send Message') }}
                </button>
            </form>
        </div>
    </section>
@endsection
