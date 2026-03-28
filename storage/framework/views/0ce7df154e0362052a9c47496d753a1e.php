<?php $__env->startSection('title', __('Add payment method')); ?>
<?php $__env->startSection('heading', __('Add payment method')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
    <p class="mb-4 text-sm text-gray-600"><?php echo e(__('Use a lowercase code without spaces (e.g. stripe, wallet). Wire it in code when you add a real integration.')); ?></p>
    <form action="<?php echo e(route('admin.payment-methods.store')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('components.admin.form-field', [
            'name' => 'code',
            'label' => __('Method code'),
            'type' => 'text',
            'value' => old('code'),
            'required' => true,
            'attributes' => ['placeholder' => 'e.g. wallet', 'pattern' => '[a-z][a-z0-9_]*'],
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('payment::admin.payment-methods.form', ['paymentMethod' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('components.admin.form-actions', [
            'submitLabel' => __('Create'),
            'cancelUrl' => route('admin.payment-methods.index'),
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </form>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/Payment\resources/views/admin/payment-methods/create.blade.php ENDPATH**/ ?>