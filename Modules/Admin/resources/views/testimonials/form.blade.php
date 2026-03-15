@php $testimonial = $testimonial ?? null; @endphp
@include('admin::components.form-field', [
    'name' => 'quote',
    'label' => __('Quote'),
    'type' => 'textarea',
    'value' => old('quote', $testimonial?->quote),
    'required' => true,
    'attributes' => ['rows' => 4],
])
@include('admin::components.form-field', [
    'name' => 'name',
    'label' => __('Name'),
    'type' => 'text',
    'value' => old('name', $testimonial?->name),
    'required' => true,
])
@include('admin::components.form-field', [
    'name' => 'photo',
    'label' => __('Photo (optional)'),
    'type' => 'file',
    'value' => '',
    'attributes' => [
        'accept' => 'image/*',
        'current' => $testimonial?->photo,
        'current_url' => $testimonial?->photo ? asset('storage/' . $testimonial->photo) : '',
    ],
])
@include('admin::components.form-field', [
    'name' => 'sort_order',
    'label' => __('Sort order'),
    'type' => 'number',
    'value' => old('sort_order', $testimonial?->sort_order ?? 0),
    'attributes' => ['min' => 0],
])
@include('admin::components.form-field', [
    'name' => 'active',
    'label' => '',
    'type' => 'checkbox',
    'value' => old('active', $testimonial?->active ?? true),
    'attributes' => ['help' => __('Active')],
])
