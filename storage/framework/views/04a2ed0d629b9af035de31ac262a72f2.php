<?php $testimonial = $testimonial ?? null; ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'quote',
    'label' => __('Quote'),
    'type' => 'textarea',
    'value' => old('quote', $testimonial?->quote),
    'required' => true,
    'attributes' => ['rows' => 4],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'name',
    'label' => __('Name'),
    'type' => 'text',
    'value' => old('name', $testimonial?->name),
    'required' => true,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'photo',
    'label' => __('Photo (optional)'),
    'type' => 'file',
    'value' => '',
    'attributes' => [
        'accept' => 'image/*',
        'current' => $testimonial?->photo,
        'current_url' => $testimonial?->photo ? get_image_url($testimonial->photo) : '',
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'sort_order',
    'label' => __('Sort order'),
    'type' => 'number',
    'value' => old('sort_order', $testimonial?->sort_order ?? 0),
    'attributes' => ['min' => 0],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'active',
    'label' => '',
    'type' => 'checkbox',
    'value' => old('active', $testimonial?->active ?? true),
    'attributes' => ['help' => __('Active')],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Testimonial\resources\views\admin\form.blade.php ENDPATH**/ ?>