

<?php $__env->startSection('title', __('Newsletter subscribers')); ?>
<?php $__env->startSection('heading', __('Newsletter subscribers')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.filter-bar'); ?>
    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('Search by email')); ?>" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->make('components.admin.table', [
    'columns' => [
        ['label' => __('ID'), 'key' => 'id', 'sort_key' => 'id'],
        ['label' => __('Email'), 'key' => 'email', 'sort_key' => 'email'],
        ['label' => __('Date'), 'key' => 'created_at', 'format' => 'datetime', 'sort_key' => 'created_at'],
    ],
    'rows' => $subscribers,
    'emptyMessage' => __('No subscribers yet.'),
    'bulk_actions' => [
        ['value' => 'delete', 'label' => __('Delete')],
    ],
    'bulk_form_action' => route('admin.newsletter.bulk'),
    'pagination' => $subscribers,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Newsletter\resources\views\admin\index.blade.php ENDPATH**/ ?>