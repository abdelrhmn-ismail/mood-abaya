<?php $__env->startSection('title', __('Add testimonial')); ?>
<?php $__env->startSection('heading', __('Add testimonial')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
<form action="<?php echo e(route('admin.testimonials.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php echo $__env->make('testimonial::admin.form', ['testimonial' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-actions', [
        'submitLabel' => __('Add testimonial'),
        'cancelUrl' => route('admin.testimonials.index'),
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</form>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Testimonial\resources\views\admin\create.blade.php ENDPATH**/ ?>