<?php $__env->startSection('title', __('Users')); ?>
<?php $__env->startSection('heading', __('Users')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.filter-bar'); ?>
    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('Search name, email, phone')); ?>" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
    <select name="is_admin" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <option value=""><?php echo e(__('All')); ?></option>
        <option value="1" <?php echo e(request('is_admin') === '1' ? 'selected' : ''); ?>><?php echo e(__('Admin')); ?></option>
        <option value="0" <?php echo e(request('is_admin') === '0' ? 'selected' : ''); ?>><?php echo e(__('Customer')); ?></option>
    </select>
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->make('components.admin.table', [
    'columns' => [
        ['label' => __('ID'), 'key' => 'id', 'sort_key' => 'id'],
        ['label' => __('Name'), 'key' => 'name', 'sort_key' => 'name'],
        ['label' => __('Email'), 'key' => 'email', 'sort_key' => 'email'],
        ['label' => __('Phone'), 'key' => 'phone'],
        ['label' => __('Admin'), 'key' => 'is_admin', 'format' => 'boolean', 'sort_key' => 'is_admin'],
        ['label' => __('Orders'), 'key' => 'orders_count'],
        ['label' => __('Registered'), 'key' => 'created_at', 'format' => 'datetime', 'sort_key' => 'created_at'],
    ],
    'rows' => $users,
    'emptyMessage' => __('No users found.'),
    'pagination' => $users,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\User\resources\views\admin\index.blade.php ENDPATH**/ ?>