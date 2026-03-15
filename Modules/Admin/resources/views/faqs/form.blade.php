@php $faq = $faq ?? null; @endphp
@include('admin::components.form-field', [
    'name' => 'question_en',
    'label' => __('Question') . ' (EN)',
    'type' => 'text',
    'value' => old('question_en', $faq?->question_en),
    'required' => true,
])
@include('admin::components.form-field', [
    'name' => 'question_ar',
    'label' => __('Question') . ' (AR)',
    'type' => 'text',
    'value' => old('question_ar', $faq?->question_ar),
])
@include('admin::components.form-field', [
    'name' => 'answer_en',
    'label' => __('Answer') . ' (EN)',
    'type' => 'textarea',
    'value' => old('answer_en', $faq?->answer_en),
    'required' => true,
    'attributes' => ['rows' => 4],
])
@include('admin::components.form-field', [
    'name' => 'answer_ar',
    'label' => __('Answer') . ' (AR)',
    'type' => 'textarea',
    'value' => old('answer_ar', $faq?->answer_ar),
    'attributes' => ['rows' => 4],
])
@include('admin::components.form-field', [
    'name' => 'sort_order',
    'label' => __('Sort order'),
    'type' => 'number',
    'value' => old('sort_order', $faq?->sort_order ?? 0),
    'attributes' => ['min' => 0],
])
@include('admin::components.form-field', [
    'name' => 'is_active',
    'label' => '',
    'type' => 'checkbox',
    'value' => old('is_active', $faq?->is_active ?? true),
    'attributes' => ['help' => __('Active (show on Contact page)')],
])
