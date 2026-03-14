@extends('admin::layouts.app')

@section('title', __('Add product'))
@section('heading', __('Add product'))

@section('content')
@php $locales = config('app.available_locales', ['en', 'ar']); @endphp
@component('admin::components.card', ['title' => null])
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @include('admin::components.form-field', [
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
    @include('admin::components.form-field', ['name' => 'sku', 'label' => __('SKU'), 'type' => 'text', 'value' => old('sku', '')])
    @include('admin::components.form-field', ['name' => 'barcode', 'label' => __('Barcode'), 'type' => 'text', 'value' => old('barcode', '')])
    @include('admin::components.form-field', ['name' => 'short_description', 'label' => __('Short description'), 'type' => 'textarea', 'value' => old('short_description', ''), 'attributes' => ['rows' => 2]])
    @include('admin::components.form-field', ['name' => 'tags', 'label' => __('Tags'), 'type' => 'text', 'value' => old('tags', ''), 'attributes' => ['placeholder' => __('Comma-separated')]])
    @include('admin::components.form-field', ['name' => 'meta_title', 'label' => __('Meta title'), 'type' => 'text', 'value' => old('meta_title', '')])
    @include('admin::components.form-field', ['name' => 'meta_description', 'label' => __('Meta description'), 'type' => 'textarea', 'value' => old('meta_description', ''), 'attributes' => ['rows' => 2]])
    @include('admin::components.form-field', ['name' => 'meta_keywords', 'label' => __('Meta keywords'), 'type' => 'text', 'value' => old('meta_keywords', ''), 'attributes' => ['placeholder' => 'keyword1, keyword2']])
    @include('admin::components.form-field', ['name' => 'og_image', 'label' => __('OG image URL'), 'type' => 'text', 'value' => old('og_image', ''), 'attributes' => ['placeholder' => 'https://']])
    @include('admin::components.form-field', ['name' => 'price', 'label' => __('Price (SAR)'), 'type' => 'number', 'value' => old('price', ''), 'required' => true, 'attributes' => ['step' => '0.01', 'min' => 0]])
    @include('admin::components.form-field', ['name' => 'compare_at_price', 'label' => __('Compare at price (SAR)'), 'type' => 'number', 'value' => old('compare_at_price', ''), 'attributes' => ['step' => '0.01', 'min' => 0, 'placeholder' => __('Original price for discount display')]])
    @include('admin::components.form-field', ['name' => 'image', 'label' => __('Image'), 'type' => 'file', 'value' => '', 'attributes' => ['accept' => 'image/*']])
    @include('admin::components.form-field', ['name' => 'stock', 'label' => __('Stock'), 'type' => 'number', 'value' => old('stock', 0), 'attributes' => ['min' => 0]])
    @include('admin::components.form-field', ['name' => 'min_order_qty', 'label' => __('Min. order qty'), 'type' => 'number', 'value' => old('min_order_qty', 1), 'attributes' => ['min' => 1]])
    @include('admin::components.form-field', ['name' => 'max_order_qty', 'label' => __('Max. order qty'), 'type' => 'number', 'value' => old('max_order_qty', ''), 'attributes' => ['min' => 1, 'placeholder' => __('Leave empty for no limit')]])
    @include('admin::components.form-field', ['name' => 'weight_kg', 'label' => __('Weight (kg)'), 'type' => 'number', 'value' => old('weight_kg', ''), 'attributes' => ['step' => '0.01', 'min' => 0]])
    @include('admin::components.form-field', ['name' => 'active', 'label' => '', 'type' => 'checkbox', 'value' => true, 'attributes' => ['help' => __('Active')]])
    @include('admin::components.form-field', ['name' => 'featured', 'label' => '', 'type' => 'checkbox', 'value' => false, 'attributes' => ['help' => __('Featured')]])
    @include('admin::components.form-actions', [
        'submitLabel' => __('Create product'),
        'cancelUrl' => route('admin.products.index'),
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
