<?php $__env->startSection('title', __('Edit payment method')); ?>
<?php $__env->startSection('heading', __('Edit payment method')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.card', ['title' => $paymentMethod->code]); ?>
    <p class="mb-4 text-sm text-gray-500"><?php echo e(__('Internal code')); ?>: <code class="rounded bg-slate-100 px-1.5 py-0.5 font-mono text-sm"><?php echo e($paymentMethod->code); ?></code>
        <?php if($paymentMethod->is_system): ?>
            <span class="ml-2 text-amber-700">(<?php echo e(__('System method — code cannot be changed')); ?>)</span>
        <?php endif; ?>
    </p>
    <form action="<?php echo e(route('admin.payment-methods.update', $paymentMethod)); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <?php echo $__env->make('payment::admin.payment-methods.form', ['paymentMethod' => $paymentMethod], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('components.admin.form-actions', [
            'submitLabel' => __('Save'),
            'cancelUrl' => route('admin.payment-methods.index'),
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </form>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Payment\resources\views\admin\payment-methods\edit.blade.php ENDPATH**/ ?>