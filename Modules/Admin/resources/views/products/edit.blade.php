@extends('admin::layouts.app')

@section('title', __('Edit product'))
@section('heading', __('Edit product'))

@section('content')
@php $locales = config('app.available_locales', ['en', 'ar']); @endphp
@component('admin::components.card', ['title' => null])
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')
    @include('admin::components.form-field', [
        'name' => 'category_id',
        'label' => __('Category'),
        'type' => 'select',
        'value' => old('category_id', $product->category_id),
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
                    'value' => old("name.{$locale}", $product->getTranslation('name', $locale, false)),
                    'required' => $loop->first,
                ])
                @include('admin::components.rich-editor', [
                    'name' => "description[{$locale}]",
                    'id' => 'description_' . $locale,
                    'label' => __('Description') . " ({$locale})",
                    'value' => old("description.{$locale}", $product->getTranslation('description', $locale, false)),
                    'errorKey' => "description.{$locale}",
                ])
            </div>
        @endforeach
    </div>
    @include('admin::components.form-field', ['name' => 'slug', 'label' => __('Slug'), 'type' => 'text', 'value' => old('slug', $product->slug)])
    @include('admin::components.form-field', ['name' => 'sku', 'label' => __('SKU'), 'type' => 'text', 'value' => old('sku', $product->sku)])
    @include('admin::components.form-field', ['name' => 'barcode', 'label' => __('Barcode'), 'type' => 'text', 'value' => old('barcode', $product->barcode)])
    @include('admin::components.form-field', ['name' => 'short_description', 'label' => __('Short description'), 'type' => 'textarea', 'value' => old('short_description', $product->short_description), 'attributes' => ['rows' => 2]])
    @include('admin::components.form-field', ['name' => 'tags', 'label' => __('Tags'), 'type' => 'text', 'value' => old('tags', $product->tags), 'attributes' => ['placeholder' => __('Comma-separated')]])
    @include('admin::components.form-field', ['name' => 'meta_title', 'label' => __('Meta title'), 'type' => 'text', 'value' => old('meta_title', $product->meta_title)])
    @include('admin::components.form-field', ['name' => 'meta_description', 'label' => __('Meta description'), 'type' => 'textarea', 'value' => old('meta_description', $product->meta_description), 'attributes' => ['rows' => 2]])
    @include('admin::components.form-field', ['name' => 'meta_keywords', 'label' => __('Meta keywords'), 'type' => 'text', 'value' => old('meta_keywords', $product->meta_keywords), 'attributes' => ['placeholder' => 'keyword1, keyword2']])
    @include('admin::components.form-field', ['name' => 'og_image', 'label' => __('OG image URL'), 'type' => 'text', 'value' => old('og_image', $product->og_image), 'attributes' => ['placeholder' => 'https://']])
    @include('admin::components.form-field', ['name' => 'price', 'label' => __('Price (SAR)'), 'type' => 'number', 'value' => old('price', $product->price), 'required' => true, 'attributes' => ['step' => '0.01', 'min' => 0]])
    @include('admin::components.form-field', ['name' => 'compare_at_price', 'label' => __('Compare at price (SAR)'), 'type' => 'number', 'value' => old('compare_at_price', $product->compare_at_price), 'attributes' => ['step' => '0.01', 'min' => 0, 'placeholder' => __('Original price for discount display')]])
    @include('admin::components.form-field', ['name' => 'image', 'label' => __('Main image'), 'type' => 'file', 'value' => '', 'attributes' => ['accept' => 'image/*', 'current' => $product->image, 'current_url' => $product->image ? \Illuminate\Support\Facades\Storage::url($product->image) : '']])
    <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">{{ __('Gallery images') }}</label>
        @if($product->images->isNotEmpty())
            <div class="mb-3 flex flex-wrap gap-3">
                @foreach($product->images as $img)
                    <div class="relative inline-block">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($img->image) }}" alt="" class="h-24 w-24 rounded border object-cover">
                        <label class="absolute right-1 top-1 flex items-center gap-1 rounded bg-red-100 px-2 py-1 text-xs text-red-700">
                            <input type="checkbox" name="delete_image_ids[]" value="{{ $img->id }}" class="rounded">
                            {{ __('Delete') }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endif
        <input type="file" name="images[]" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:rounded file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200">
        <p class="mt-1 text-xs text-gray-500">{{ __('Add more images. Check Delete to remove existing.') }}</p>
    </div>
    @include('admin::components.form-field', ['name' => 'stock', 'label' => __('Stock'), 'type' => 'number', 'value' => old('stock', $product->stock), 'attributes' => ['min' => 0]])
    @include('admin::components.form-field', ['name' => 'min_order_qty', 'label' => __('Min. order qty'), 'type' => 'number', 'value' => old('min_order_qty', $product->min_order_qty ?? 1), 'attributes' => ['min' => 1]])
    @include('admin::components.form-field', ['name' => 'max_order_qty', 'label' => __('Max. order qty'), 'type' => 'number', 'value' => old('max_order_qty', $product->max_order_qty), 'attributes' => ['min' => 1, 'placeholder' => __('Leave empty for no limit')]])
    @include('admin::components.form-field', ['name' => 'weight_kg', 'label' => __('Weight (kg)'), 'type' => 'number', 'value' => old('weight_kg', $product->weight_kg), 'attributes' => ['step' => '0.01', 'min' => 0]])
    @include('admin::components.form-field', ['name' => 'active', 'label' => '', 'type' => 'checkbox', 'value' => $product->active, 'attributes' => ['help' => __('Active')]])
    @include('admin::components.form-field', ['name' => 'featured', 'label' => '', 'type' => 'checkbox', 'value' => $product->featured, 'attributes' => ['help' => __('Featured')]])

    {{-- Variants (size/color with own SKU, price, stock) --}}
    <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-6">
        <h3 class="mb-4 text-sm font-semibold text-gray-900">{{ __('Product variants') }}</h3>
        <p class="mb-4 text-xs text-gray-500">{{ __('Add variants with their own SKU, price and stock. Use attributes JSON e.g. {"Size":"M","Color":"Black"} for one variant.') }}</p>
        @if($product->variants->isNotEmpty())
            <table class="mb-4 w-full rounded-lg border border-gray-200 bg-white text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-3 py-2 text-left font-medium text-gray-600">{{ __('SKU') }}</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-600">{{ __('Attributes') }}</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-600">{{ __('Price') }}</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-600">{{ __('Stock') }}</th>
                        <th class="px-3 py-2 text-right font-medium text-gray-600">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->variants as $v)
                        <tr class="border-t border-gray-100">
                            <td class="px-3 py-2 font-mono">{{ $v->sku ?? '—' }}</td>
                            <td class="px-3 py-2">{{ $v->getDisplayName() }}</td>
                            <td class="px-3 py-2">{{ number_format($v->price, 2) }} SAR</td>
                            <td class="px-3 py-2">{{ $v->stock }}</td>
                            <td class="px-3 py-2 text-right">
                                <form action="{{ route('admin.products.variants.destroy', [$product, $v]) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Remove this variant?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">{{ __('Remove') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <form action="{{ route('admin.products.variants.store', $product) }}" method="POST" class="flex flex-wrap items-end gap-3">
            @csrf
            <div class="min-w-[120px]">
                <label class="block text-xs font-medium text-gray-600">{{ __('SKU') }}</label>
                <input type="text" name="sku" class="mt-1 block w-full rounded-lg border border-gray-300 text-sm" placeholder="SKU-M">
            </div>
            <div class="min-w-[100px]">
                <label class="block text-xs font-medium text-gray-600">{{ __('Price (SAR)') }} *</label>
                <input type="number" name="price" step="0.01" min="0" required class="mt-1 block w-full rounded-lg border border-gray-300 text-sm" value="0">
            </div>
            <div class="min-w-[80px]">
                <label class="block text-xs font-medium text-gray-600">{{ __('Stock') }} *</label>
                <input type="number" name="stock" min="0" required class="mt-1 block w-full rounded-lg border border-gray-300 text-sm" value="0">
            </div>
            <div class="min-w-[200px] flex-1">
                <label class="block text-xs font-medium text-gray-600">{{ __('Attributes (JSON)') }}</label>
                <input type="text" name="attributes" class="mt-1 block w-full rounded-lg border border-gray-300 font-mono text-sm" placeholder='{"Size":"M"} or {"Color":"Black"}'>
            </div>
            <button type="submit" class="rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white hover:bg-brand-teal-dark">{{ __('Add variant') }}</button>
        </form>
    </div>

    @include('admin::components.form-actions', [
        'submitLabel' => __('Update product'),
        'cancelUrl' => route('admin.products.index'),
    ])
</form>
@endcomponent
@push('admin-scripts')
@include('admin::components.editor-scripts')
@endpush
@endsection
