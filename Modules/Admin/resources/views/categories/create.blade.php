@extends('admin::layouts.app')

@section('title', __('Add category'))
@section('heading', __('Add category'))

@section('content')
@php $locales = config('app.available_locales', ['en', 'ar']); @endphp
@component('admin::components.card', ['title' => null])
<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    <div>
        <p class="mb-2 text-sm font-medium text-gray-700">{{ __('Translations') }}</p>
        <div class="flex gap-2 border-b border-gray-200">
            @foreach($locales as $locale)
                <button type="button" class="locale-tab rounded-t px-4 py-2 text-sm font-medium {{ $loop->first ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-100' }}" data-locale="{{ $locale }}">{{ $locale === 'en' ? __('English') : __('Arabic') }}</button>
            @endforeach
        </div>
        @foreach($locales as $locale)
            <div class="locale-panel mt-4 space-y-4 {{ $loop->first ? '' : 'hidden' }}" data-locale="{{ $locale }}">
                @include('admin::components.form-field', [
                    'name' => "name[{$locale}]",
                    'label' => __('Name') . " ({$locale})",
                    'type' => 'text',
                    'value' => old("name.{$locale}", ''),
                    'required' => $loop->first,
                ])
                @include('admin::components.rich-editor', [
                    'name' => "description[{$locale}]",
                    'id' => 'description_' . $locale,
                    'label' => __('Description') . " ({$locale})",
                    'value' => old("description.{$locale}", ''),
                    'errorKey' => "description.{$locale}",
                ])
            </div>
        @endforeach
    </div>
    @include('admin::components.form-field', ['name' => 'slug', 'label' => __('Slug'), 'type' => 'text', 'value' => old('slug', '')])
    @include('admin::components.form-field', ['name' => 'image', 'label' => __('Image'), 'type' => 'file', 'value' => '', 'attributes' => ['accept' => 'image/*']])
    @include('admin::components.form-field', ['name' => 'sort_order', 'label' => __('Sort order'), 'type' => 'number', 'value' => old('sort_order', 0), 'attributes' => ['min' => 0]])
    @include('admin::components.form-field', ['name' => 'active', 'label' => '', 'type' => 'checkbox', 'value' => true, 'attributes' => ['help' => __('Active')]])
    @include('admin::components.form-actions', [
        'submitLabel' => __('Create category'),
        'cancelUrl' => route('admin.categories.index'),
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
            height: 220,
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
