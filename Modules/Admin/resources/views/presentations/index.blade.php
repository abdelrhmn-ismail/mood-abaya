@extends('admin::layouts.app')

@section('title', __('Presentation'))
@section('heading', __('Presentation'))

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <p class="mb-6 text-slate-600">{{ __('Open the store presentation in Arabic or English. Each opens in a new tab.') }}</p>
    <div class="flex flex-wrap gap-4">
        <a href="{{ $arUrl }}" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 rounded-xl border-2 border-brand-teal bg-brand-teal/5 px-6 py-4 text-lg font-semibold text-brand-teal transition hover:bg-brand-teal hover:text-white">
            <span class="material-icons text-2xl">slideshow</span>
            {{ __('Presentation') }} — {{ __('Arabic') }}
        </a>
        <a href="{{ $enUrl }}" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 rounded-xl border-2 border-brand-teal bg-brand-teal/5 px-6 py-4 text-lg font-semibold text-brand-teal transition hover:bg-brand-teal hover:text-white">
            <span class="material-icons text-2xl">slideshow</span>
            {{ __('Presentation') }} — {{ __('English') }}
        </a>
    </div>
</div>
@endsection
