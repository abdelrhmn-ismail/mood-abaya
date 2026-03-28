<?php $__env->startSection('title', __('Products')); ?>
<?php $__env->startSection('heading', __('Products')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.page-header', [
    'actionUrl' => route('admin.products.create'),
    'actionLabel' => __('Add product'),
]); ?>
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('components.admin.filter-bar'); ?>
    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('Search')); ?>" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
    <select name="category_id" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <option value=""><?php echo e(__('All categories')); ?></option>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <select name="active" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <option value=""><?php echo e(__('All statuses')); ?></option>
        <option value="1" <?php echo e(request('active') === '1' ? 'selected' : ''); ?>><?php echo e(__('Active')); ?></option>
        <option value="0" <?php echo e(request('active') === '0' ? 'selected' : ''); ?>><?php echo e(__('Inactive')); ?></option>
    </select>
    <select name="featured" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <option value=""><?php echo e(__('All featured')); ?></option>
        <option value="1" <?php echo e(request('featured') === '1' ? 'selected' : ''); ?>><?php echo e(__('Featured')); ?></option>
        <option value="0" <?php echo e(request('featured') === '0' ? 'selected' : ''); ?>><?php echo e(__('Not featured')); ?></option>
    </select>
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->make('components.admin.table', [
    'columns' => [
        ['label' => __('Name'), 'key' => 'name', 'sort_key' => 'name'],
        ['label' => __('Category'), 'key' => 'category.name'],
        ['label' => __('Price'), 'key' => 'price', 'format' => 'price', 'sort_key' => 'price'],
        ['label' => __('Stock'), 'key' => 'stock', 'sort_key' => 'stock'],
        ['label' => __('Active'), 'key' => 'active', 'format' => 'boolean', 'sort_key' => 'active'],
    ],
    'rows' => $products,
    'emptyMessage' => __('No products yet.'),
    'actions' => [
        'edit_route' => 'admin.products.edit',
        'delete_route' => 'admin.products.destroy',
        'delete_confirm' => __('Delete this product?'),
    ],
    'bulk_actions' => [
        ['value' => 'activate', 'label' => __('Activate')],
        ['value' => 'deactivate', 'label' => __('Deactivate')],
        ['value' => 'delete', 'label' => __('Delete')],
    ],
    'bulk_form_action' => route('admin.products.bulk'),
    'pagination' => $products,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Shop\resources\views\admin\products\index.blade.php ENDPATH**/ ?>