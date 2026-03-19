@extends('admin.layouts.app')

@section('title', __('Edit category'))
@section('heading', __('Edit category'))

@section('content')
@php $locales = config('app.available_locales', ['en', 'ar']); @endphp
@component('components.admin.card', ['title' => null])
<form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')
    <div>
        <p class="mb-2 text-sm font-medium text-gray-700">{{ __('Translations') }}</p>
        <div class="flex gap-2 border-b border-gray-200">
            @foreach($locales as $locale)
                <button type="button" class="locale-tab rounded-t px-4 py-2 text-sm font-medium {{ $loop->first ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-100' }}" data-locale="{{ $locale }}">{{ $locale === 'en' ? __('English') : __('Arabic') }}</button>
            @endforeach
        </div>
        @foreach($locales as $locale)
            <div class="locale-panel mt-4 space-y-4 {{ $loop->first ? '' : 'hidden' }}" data-locale="{{ $locale }}">
                @include('components.admin.form-field', [
                    'name' => "name[{$locale}]",
                    'label' => __('Name') . " ({$locale})",
                    'type' => 'text',
                    'value' => old("name.{$locale}", $category->getTranslation('name', $locale, false)),
                    'required' => $loop->first,
                ])
                @include('components.admin.rich-editor', [
                    'name' => "description[{$locale}]",
                    'id' => 'description_' . $locale,
                    'label' => __('Description') . " ({$locale})",
                    'value' => old("description.{$locale}", $category->getTranslation('description', $locale, false)),
                    'errorKey' => "description.{$locale}",
                ])
            </div>
        @endforeach
    </div>
    @include('components.admin.form-field', ['name' => 'slug', 'label' => __('Slug'), 'type' => 'text', 'value' => old('slug', $category->slug)])
    @include('components.admin.form-field', ['name' => 'image', 'label' => __('Image'), 'type' => 'file', 'value' => '', 'attributes' => ['accept' => 'image/*', 'current' => $category->image, 'current_url' => $category->image ? \Illuminate\Support\Facades\Storage::url($category->image) : '']])
    @include('components.admin.form-field', ['name' => 'sort_order', 'label' => __('Sort order'), 'type' => 'number', 'value' => old('sort_order', $category->sort_order), 'attributes' => ['min' => 0]])
    @include('components.admin.form-field', ['name' => 'active', 'label' => '', 'type' => 'checkbox', 'value' => $category->active, 'attributes' => ['help' => __('Active')]])
    @include('components.admin.form-actions', [
        'submitLabel' => __('Update category'),
        'cancelUrl' => route('admin.categories.index'),
    ])
</form>
@endcomponent
@push('admin-scripts')
@include('components.admin.editor-scripts')
@endpush
@endsection
