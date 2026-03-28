@extends('admin.layouts.app')

@section('title', __('Add product'))
@section('heading', __('Add product'))

@section('content')
@php $locales = config('app.available_locales', ['en', 'ar']); @endphp
@component('components.admin.card', ['title' => null])
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @include('components.admin.form-field', [
        'name' => 'category_id',
        'label' => __('Category'),
        'type' => 'select',
        'value' => old('category_id'),
        'required' => true,
        'options' => collect($categories)->map(fn($c) => ['value' => $c->id, 'label' => $c->name])->values()->all(),
    ])
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
                    'value' => old("name.{$locale}", ''),
                    'required' => $loop->first,
                ])
                @include('components.admin.rich-editor', [
                    'name' => "description[{$locale}]",
                    'id' => 'description_' . $locale,
                    'label' => __('Description') . " ({$locale})",
                    'value' => old("description.{$locale}", ''),
                    'errorKey' => "description.{$locale}",
                ])
            </div>
        @endforeach
    </div>
    @include('components.admin.form-field', ['name' => 'slug', 'label' => __('Slug'), 'type' => 'text', 'value' => old('slug', '')])
    @include('components.admin.form-field', ['name' => 'sku', 'label' => __('SKU'), 'type' => 'text', 'value' => old('sku', '')])
    @include('components.admin.form-field', ['name' => 'barcode', 'label' => __('Barcode'), 'type' => 'text', 'value' => old('barcode', '')])
    @include('components.admin.form-field', ['name' => 'short_description', 'label' => __('Short description'), 'type' => 'textarea', 'value' => old('short_description', ''), 'attributes' => ['rows' => 2]])
    @include('components.admin.form-field', ['name' => 'tags', 'label' => __('Tags'), 'type' => 'text', 'value' => old('tags', ''), 'attributes' => ['placeholder' => __('Comma-separated')]])
    @include('components.admin.form-field', ['name' => 'meta_title', 'label' => __('Meta title'), 'type' => 'text', 'value' => old('meta_title', '')])
    @include('components.admin.form-field', ['name' => 'meta_description', 'label' => __('Meta description'), 'type' => 'textarea', 'value' => old('meta_description', ''), 'attributes' => ['rows' => 2]])
    @include('components.admin.form-field', ['name' => 'meta_keywords', 'label' => __('Meta keywords'), 'type' => 'text', 'value' => old('meta_keywords', ''), 'attributes' => ['placeholder' => __('Meta keywords placeholder')]])
    @include('components.admin.form-field', ['name' => 'og_image', 'label' => __('OG image URL'), 'type' => 'text', 'value' => old('og_image', ''), 'attributes' => ['placeholder' => __('URL placeholder https')]])
    @include('components.admin.form-field', ['name' => 'price', 'label' => __('Price (SAR)'), 'type' => 'number', 'value' => old('price', ''), 'required' => true, 'attributes' => ['step' => '0.01', 'min' => 0]])
    @include('components.admin.form-field', ['name' => 'compare_at_price', 'label' => __('Compare at price (SAR)'), 'type' => 'number', 'value' => old('compare_at_price', ''), 'attributes' => ['step' => '0.01', 'min' => 0, 'placeholder' => __('Original price for discount display')]])
    @include('components.admin.form-field', ['name' => 'image', 'label' => __('Main image'), 'type' => 'file', 'value' => '', 'attributes' => ['accept' => 'image/*']])
    <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">{{ __('Gallery images') }}</label>
        <input type="file" name="images[]" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:rounded file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200">
        <p class="mt-1 text-xs text-gray-500">{{ __('Optional. Add multiple product images.') }}</p>
    </div>
    <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">{{ __('Product video') }}</label>
        <p class="mb-2 text-xs text-gray-500">{{ __('Upload MP4, WebM, or MOV (max 50 MB), or paste a public URL below.') }}</p>
        <input type="file" name="video_file" accept="video/mp4,video/webm,video/quicktime,.mp4,.webm,.mov" class="block w-full text-sm text-gray-500 file:mr-4 file:rounded file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200">
        @include('components.admin.form-field', ['name' => 'video', 'label' => __('Video URL (optional)'), 'type' => 'text', 'value' => old('video', ''), 'attributes' => ['placeholder' => __('URL placeholder https')]])
    </div>
    @include('components.admin.form-field', ['name' => 'stock', 'label' => __('Stock'), 'type' => 'number', 'value' => old('stock', 0), 'attributes' => ['min' => 0]])
    @include('components.admin.form-field', ['name' => 'min_order_qty', 'label' => __('Min. order qty'), 'type' => 'number', 'value' => old('min_order_qty', 1), 'attributes' => ['min' => 1]])
    @include('components.admin.form-field', ['name' => 'max_order_qty', 'label' => __('Max. order qty'), 'type' => 'number', 'value' => old('max_order_qty', ''), 'attributes' => ['min' => 1, 'placeholder' => __('Leave empty for no limit')]])
    @include('components.admin.form-field', ['name' => 'weight_kg', 'label' => __('Weight (kg)'), 'type' => 'number', 'value' => old('weight_kg', ''), 'attributes' => ['step' => '0.01', 'min' => 0]])
    @include('components.admin.form-field', ['name' => 'active', 'label' => '', 'type' => 'checkbox', 'value' => true, 'attributes' => ['help' => __('Active')]])
    @include('components.admin.form-field', ['name' => 'featured', 'label' => '', 'type' => 'checkbox', 'value' => false, 'attributes' => ['help' => __('Featured')]])
    @include('components.admin.form-actions', [
        'submitLabel' => __('Create product'),
        'cancelUrl' => route('admin.products.index'),
    ])
</form>
@endcomponent
@push('admin-scripts')
@include('components.admin.editor-scripts')
@endpush
@endsection
