<?php $faq = $faq ?? null; ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'question_en',
    'label' => __('Question') . ' (EN)',
    'type' => 'text',
    'value' => old('question_en', $faq?->question_en),
    'required' => true,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'question_ar',
    'label' => __('Question') . ' (AR)',
    'type' => 'text',
    'value' => old('question_ar', $faq?->question_ar),
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'answer_en',
    'label' => __('Answer') . ' (EN)',
    'type' => 'textarea',
    'value' => old('answer_en', $faq?->answer_en),
    'required' => true,
    'attributes' => ['rows' => 4],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'answer_ar',
    'label' => __('Answer') . ' (AR)',
    'type' => 'textarea',
    'value' => old('answer_ar', $faq?->answer_ar),
    'attributes' => ['rows' => 4],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'sort_order',
    'label' => __('Sort order'),
    'type' => 'number',
    'value' => old('sort_order', $faq?->sort_order ?? 0),
    'attributes' => ['min' => 0],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'is_active',
    'label' => '',
    'type' => 'checkbox',
    'value' => old('is_active', $faq?->is_active ?? true),
    'attributes' => ['help' => __('Active (show on Contact page)')],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Faq\resources\views\admin\form.blade.php ENDPATH**/ ?>