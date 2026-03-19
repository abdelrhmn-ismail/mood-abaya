@extends('admin.layouts.app')

@section('title', __('Edit') . ': ' . $page->page_name)
@section('heading', __('Edit') . ': ' . $page->page_name)

@section('content')
@php $locales = config('app.available_locales', ['en', 'ar']); @endphp
@component('components.admin.card', ['title' => null])
<form action="{{ route('admin.page-contents.update', $page) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    <p class="text-sm text-gray-600">{{ $page->page_name }} — {{ __('Edit content in English and Arabic.') }}</p>
    <div>
        <p class="mb-2 text-sm font-medium text-gray-700">{{ __('Translations') }}</p>
        <div class="flex gap-2 border-b border-gray-200">
            @foreach($locales as $locale)
                <button type="button" class="locale-tab rounded-t px-4 py-2 text-sm font-medium {{ $loop->first ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-100' }}" data-locale="{{ $locale }}">{{ $locale === 'en' ? __('English') : __('Arabic') }}</button>
            @endforeach
        </div>
        @foreach($locales as $locale)
            @php
                $contentKey = 'page_content_' . $locale;
                $value = old($contentKey, $page->$contentKey ?? '');
            @endphp
            <div class="locale-panel mt-4 {{ $loop->first ? '' : 'hidden' }}" data-locale="{{ $locale }}">
                @include('components.admin.rich-editor', [
                    'name' => $contentKey,
                    'id' => 'page_content_' . $locale,
                    'label' => __('Content') . ' (' . ($locale === 'en' ? __('English') : __('Arabic')) . ')',
                    'value' => $value,
                    'errorKey' => $contentKey,
                ])
            </div>
        @endforeach
    </div>
    @include('components.admin.form-actions', [
        'submitLabel' => __('Save'),
        'cancelUrl' => route('admin.page-contents.index'),
    ])
</form>
@endcomponent
@push('admin-scripts')
@include('components.admin.editor-scripts')
@endpush
@endsection
