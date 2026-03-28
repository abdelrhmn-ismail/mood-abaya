<?php $__env->startSection('title', __('Edit testimonial')); ?>
<?php $__env->startSection('heading', __('Edit testimonial')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
<form action="<?php echo e(route('admin.testimonials.update', $testimonial)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <?php echo $__env->make('testimonial::admin.form', ['testimonial' => $testimonial], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-actions', [
        'submitLabel' => __('Update testimonial'),
        'cancelUrl' => route('admin.testimonials.index'),
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</form>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Testimonial\resources\views\admin\edit.blade.php ENDPATH**/ ?>