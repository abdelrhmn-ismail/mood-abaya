@extends('frontend.layouts.app')

@section('title', __('Contact Us') . ' – ' . config('app.name'))
@section('description', __('Contact Us'))

@section('content')
    <section class="py-16 md:py-20">
        <div class="container mx-auto px-4 max-w-2xl">
            <h1 class="text-3xl font-bold mb-8">{{ __('Contact Us') }}</h1>

            @if(session('success'))
                <div class="mb-6 rounded-lg bg-green-100 text-green-800 px-4 py-3" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-gray-700">{{ __('Your Name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                           maxlength="255">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-700">{{ __('Your Email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="subject" class="mb-2 block text-sm font-medium text-gray-700">{{ __('Subject') }}</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                           class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                           maxlength="255">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="message" class="mb-2 block text-sm font-medium text-gray-700">{{ __('Message') }}</label>
                    <textarea name="message" id="message" rows="5" required
                              class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                              maxlength="10000">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                        class="rounded-lg bg-blue-600 px-6 py-2.5 font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    {{ __('Send Message') }}
                </button>
            </form>
        </div>
    </section>
@endsection
