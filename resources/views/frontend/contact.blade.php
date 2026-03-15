@extends('frontend.layouts.app')

@section('title', __('Contact Us') . ' – ' . config('app.name'))
@section('description', __('Contact Us'))

@section('content')
    <x-frontend.hero-header :title="__('Contact Us')" :subtitle="__('We would love to hear from you.')" setting="hero_contact" />

    {{-- Q&A / FAQ section with accordions --}}
    @if(isset($faqs) && $faqs->isNotEmpty())
    <section class="border-b border-slate-200 bg-brand-white py-14 md:py-16">
        <div class="container mx-auto max-w-3xl px-4">
            <h2 class="text-center text-2xl font-bold text-brand-black md:text-3xl">{{ __('Frequently asked questions') }}</h2>
            <p class="mx-auto mt-2 max-w-xl text-center text-brand-black/70">
                {{ __('Quick answers to common questions. Can\'t find what you need? Send us a message below.') }}
            </p>
            <div class="mt-10 space-y-2" x-data="{ openIndex: null }">
                @foreach($faqs as $index => $faq)
                    <div class="rounded-xl border border-slate-200 bg-slate-50/50 transition hover:border-brand-teal/30">
                        <button type="button"
                                @click="openIndex = openIndex === {{ $index }} ? null : {{ $index }}"
                                class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left"
                                :aria-expanded="openIndex === {{ $index }}"
                                aria-controls="faq-answer-{{ $index }}"
                                id="faq-question-{{ $index }}">
                            <span class="font-semibold text-brand-black">{{ $faq->question }}</span>
                            <span class="material-icons shrink-0 text-brand-teal transition-transform duration-200" :class="{ 'rotate-180': openIndex === {{ $index }} }">expand_more</span>
                        </button>
                        <div id="faq-answer-{{ $index }}"
                             role="region"
                             aria-labelledby="faq-question-{{ $index }}"
                             x-show="openIndex === {{ $index }}"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             x-cloak
                             class="border-t border-slate-200">
                            <div class="px-5 py-4 text-brand-black/80 prose prose-sm max-w-none prose-p:my-2 prose-ul:my-2">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section class="bg-slate-50 py-16 md:py-20">
        <div class="container mx-auto max-w-2xl px-4">
            <h2 class="text-center text-xl font-bold text-brand-black md:text-2xl">{{ __('Send us a message') }}</h2>
            <p class="mb-2 mt-2 text-center text-brand-black/80">
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

            <div class="mt-12 flex flex-wrap items-center justify-center gap-6 rounded-2xl border border-slate-200 bg-brand-white p-6">
                <div class="flex items-center gap-3 text-brand-black/80">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-gold/20 text-brand-teal">
                        <span class="material-icons text-xl">schedule</span>
                    </span>
                    <span class="text-sm">{{ __('We typically respond within 24 hours on business days.') }}</span>
                </div>
                <div class="flex items-center gap-3 text-brand-black/80">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-teal/10 text-brand-teal">
                        <span class="material-icons text-xl">support_agent</span>
                    </span>
                    <span class="text-sm">{{ __('Need urgent help? Mention it in your message.') }}</span>
                </div>
            </div>
        </div>
    </section>
@endsection
