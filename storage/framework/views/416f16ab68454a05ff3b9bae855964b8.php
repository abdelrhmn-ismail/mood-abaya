<?php $__env->startSection('title', __('Add post')); ?>
<?php $__env->startSection('heading', __('Add post')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
<form action="<?php echo e(route('admin.posts.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php echo $__env->make('blog::admin.form', ['post' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-actions', [
        'submitLabel' => __('Create post'),
        'cancelUrl' => route('admin.posts.index'),
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</form>
<?php echo $__env->renderComponent(); ?>
<?php $__env->startPush('admin-scripts'); ?>
<?php echo $__env->make('components.admin.editor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Blog\resources\views\admin\create.blade.php ENDPATH**/ ?>