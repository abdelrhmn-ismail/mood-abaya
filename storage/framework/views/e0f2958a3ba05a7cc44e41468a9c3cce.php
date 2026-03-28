<?php $__env->startSection('title', __('Categories')); ?>
<?php $__env->startSection('heading', __('Categories')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.page-header', [
    'actionUrl' => route('admin.categories.create'),
    'actionLabel' => __('Add category'),
]); ?>
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('components.admin.filter-bar'); ?>
    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('Search')); ?>" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    <select name="active" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value=""><?php echo e(__('All statuses')); ?></option>
        <option value="1" <?php echo e(request('active') === '1' ? 'selected' : ''); ?>><?php echo e(__('Active')); ?></option>
        <option value="0" <?php echo e(request('active') === '0' ? 'selected' : ''); ?>><?php echo e(__('Inactive')); ?></option>
    </select>
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->make('components.admin.table', [
    'columns' => [
        ['label' => __('Name'), 'key' => 'name', 'sort_key' => 'name'],
        ['label' => __('Slug'), 'key' => 'slug', 'class' => 'font-mono', 'sort_key' => 'slug'],
        ['label' => __('Sort'), 'key' => 'sort_order', 'sort_key' => 'sort_order'],
        ['label' => __('Active'), 'key' => 'active', 'format' => 'boolean', 'sort_key' => 'active'],
    ],
    'rows' => $categories,
    'emptyMessage' => __('No categories yet.'),
    'actions' => [
        'edit_route' => 'admin.categories.edit',
        'delete_route' => 'admin.categories.destroy',
        'delete_confirm' => __('Delete this category?'),
    ],
    'bulk_actions' => [
        ['value' => 'activate', 'label' => __('Activate')],
        ['value' => 'deactivate', 'label' => __('Deactivate')],
        ['value' => 'delete', 'label' => __('Delete')],
    ],
    'bulk_form_action' => route('admin.categories.bulk'),
    'pagination' => $categories,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Shop\resources\views\admin\categories\index.blade.php ENDPATH**/ ?>