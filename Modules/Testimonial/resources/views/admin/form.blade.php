@php $testimonial = $testimonial ?? null; @endphp
@include('components.admin.form-field', [
    'name' => 'quote',
    'label' => __('Quote'),
    'type' => 'textarea',
    'value' => old('quote', $testimonial?->quote),
    'required' => true,
    'attributes' => ['rows' => 4],
])
@include('components.admin.form-field', [
    'name' => 'name',
    'label' => __('Name'),
    'type' => 'text',
    'value' => old('name', $testimonial?->name),
    'required' => true,
])
@include('components.admin.form-field', [
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
@include('components.admin.form-field', [
    'name' => 'sort_order',
    'label' => __('Sort order'),
    'type' => 'number',
    'value' => old('sort_order', $testimonial?->sort_order ?? 0),
    'attributes' => ['min' => 0],
])
@include('components.admin.form-field', [
    'name' => 'active',
    'label' => '',
    'type' => 'checkbox',
    'value' => old('active', $testimonial?->active ?? true),
    'attributes' => ['help' => __('Active')],
])
