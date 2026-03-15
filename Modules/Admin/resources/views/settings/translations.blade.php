@extends('admin::layouts.app')

@section('title', __('Translations'))
@section('heading', __('Translations'))

@section('content')
@component('admin::components.card', ['title' => __('Edit language strings (ar / en)')])
<p class="mb-6 text-sm text-gray-600">{{ __('Override values from lang files. Leave blank to use file default.') }}</p>
<form action="{{ route('admin.translations.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
        @foreach($translations as $key => $vals)
            <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-4 shadow-sm transition hover:border-gray-300">
                <label class="mb-3 block font-mono text-sm font-medium text-gray-600">{{ $key }}</label>
                <div class="space-y-3">
                    <div>
                        <span class="mb-1 block text-xs font-medium text-gray-500">{{ __('English') }}</span>
                        <input type="text" name="translations[{{ $key }}][en]" value="{{ old("translations.{$key}.en", $vals['en']) }}"
                               class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                    </div>
                    <div>
                        <span class="mb-1 block text-xs font-medium text-gray-500">{{ __('Arabic') }}</span>
                        <input type="text" name="translations[{{ $key }}][ar]" value="{{ old("translations.{$key}.ar", $vals['ar']) }}"
                               class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20" dir="rtl">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @include('admin::components.form-actions', [
        'submitLabel' => __('Save translations'),
        'cancelUrl' => route('admin.settings.edit'),
    ])
</form>
@endcomponent
@endsection
