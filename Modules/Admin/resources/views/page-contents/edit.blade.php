@extends('admin::layouts.app')

@section('title', __('Edit') . ': ' . $page->page_name)
@section('heading', __('Edit') . ': ' . $page->page_name)

@section('content')
@php $locales = config('app.available_locales', ['en', 'ar']); @endphp
@component('admin::components.card', ['title' => null])
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
                @include('admin::components.rich-editor', [
                    'name' => $contentKey,
                    'id' => 'page_content_' . $locale,
                    'label' => __('Content') . ' (' . ($locale === 'en' ? __('English') : __('Arabic')) . ')',
                    'value' => $value,
                    'errorKey' => $contentKey,
                ])
            </div>
        @endforeach
    </div>
    @include('admin::components.form-actions', [
        'submitLabel' => __('Save'),
        'cancelUrl' => route('admin.page-contents.index'),
    ])
</form>
@endcomponent
@push('admin-scripts')
@php $tinymceKey = \App\Models\Setting::get('tinymce_api_key') ?: 'no-api-key'; @endphp
<script src="https://cdn.tiny.cloud/1/{{ $tinymceKey }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof tinymce !== 'undefined' && document.querySelectorAll('.rich-editor').length) {
        tinymce.init({
            selector: '.rich-editor',
            height: 320,
            menubar: false,
            plugins: 'lists link code',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link | removeformat | code',
            content_style: 'body { font-family: inherit; font-size: 14px; }',
            directionality: document.documentElement.dir || 'ltr',
        });
    }
    document.querySelectorAll('.locale-tab').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var locale = this.getAttribute('data-locale');
            document.querySelectorAll('.locale-tab').forEach(function(b) { b.classList.remove('bg-gray-200', 'text-gray-900'); b.classList.add('text-gray-600'); });
            this.classList.add('bg-gray-200', 'text-gray-900'); this.classList.remove('text-gray-600');
            document.querySelectorAll('.locale-panel').forEach(function(p) {
                p.classList.toggle('hidden', p.getAttribute('data-locale') !== locale);
            });
        });
    });
});
</script>
@endpush
@endsection
