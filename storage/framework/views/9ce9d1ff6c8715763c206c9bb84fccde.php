<?php $pm = $paymentMethod ?? null; $isEdit = $pm !== null; ?>

<?php echo $__env->make('components.admin.form-field', [
    'name' => 'name_en',
    'label' => __('Display name') . ' (EN)',
    'type' => 'text',
    'value' => old('name_en', $pm?->name_en),
    'required' => true,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'name_ar',
    'label' => __('Display name') . ' (AR)',
    'type' => 'text',
    'value' => old('name_ar', $pm?->name_ar),
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'description_en',
    'label' => __('Short description (checkout)') . ' (EN)',
    'type' => 'text',
    'value' => old('description_en', $pm?->description_en),
    'attributes' => ['placeholder' => __('Optional line under the method name')],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'description_ar',
    'label' => __('Short description (checkout)') . ' (AR)',
    'type' => 'text',
    'value' => old('description_ar', $pm?->description_ar),
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'instructions_en',
    'label' => __('Customer instructions / bank details') . ' (EN)',
    'type' => 'textarea',
    'value' => old('instructions_en', $pm?->instructions_en),
    'attributes' => ['rows' => 6, 'placeholder' => __('IBAN, account name, bank name — shown when this method is selected.')],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'instructions_ar',
    'label' => __('Customer instructions / bank details') . ' (AR)',
    'type' => 'textarea',
    'value' => old('instructions_ar', $pm?->instructions_ar),
    'attributes' => ['rows' => 6],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'sort_order',
    'label' => __('Sort order'),
    'type' => 'number',
    'value' => old('sort_order', $pm?->sort_order ?? 0),
    'attributes' => ['min' => 0],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'is_active',
    'label' => '',
    'type' => 'checkbox',
    'value' => old('is_active', $pm?->is_active ?? true),
    'attributes' => ['help' => __('Active (shown at checkout)')],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'requires_proof',
    'label' => '',
    'type' => 'checkbox',
    'value' => old('requires_proof', $pm?->requires_proof ?? false),
    'attributes' => ['help' => __('Require receipt / proof upload')],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'requires_admin_approval',
    'label' => '',
    'type' => 'checkbox',
    'value' => old('requires_admin_approval', $pm?->requires_admin_approval ?? false),
    'attributes' => ['help' => __('Hold order until staff approves payment (e.g. bank transfer)')],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/Payment\resources/views/admin/payment-methods/form.blade.php ENDPATH**/ ?>