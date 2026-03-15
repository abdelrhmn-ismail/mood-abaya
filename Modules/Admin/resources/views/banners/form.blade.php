@php $banner = $banner ?? null; @endphp
@include('admin::components.form-field', [
    'name' => 'title',
    'label' => __('Title'),
    'type' => 'text',
    'value' => old('title', $banner?->title),
    'required' => true,
    'attributes' => ['placeholder' => __('e.g. Free shipping this week')],
])
@include('admin::components.form-field', [
    'name' => 'link',
    'label' => __('Link (optional)'),
    'type' => 'text',
    'value' => old('link', $banner?->link),
    'attributes' => ['placeholder' => 'https://'],
])
@include('admin::components.form-field', [
    'name' => 'start_at',
    'label' => __('Start date'),
    'type' => 'date',
    'value' => old('start_at', $banner?->start_at?->format('Y-m-d')),
])
@include('admin::components.form-field', [
    'name' => 'end_at',
    'label' => __('End date'),
    'type' => 'date',
    'value' => old('end_at', $banner?->end_at?->format('Y-m-d')),
])
@include('admin::components.form-field', [
    'name' => 'sort_order',
    'label' => __('Sort order'),
    'type' => 'number',
    'value' => old('sort_order', $banner?->sort_order ?? 0),
    'attributes' => ['min' => 0],
])
@include('admin::components.form-field', [
    'name' => 'active',
    'label' => '',
    'type' => 'checkbox',
    'value' => old('active', $banner?->active ?? true),
    'attributes' => ['help' => __('Active')],
])
