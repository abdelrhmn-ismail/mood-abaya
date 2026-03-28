<?php $__env->startSection('title', __('Contact messages')); ?>
<?php $__env->startSection('heading', __('Contact messages')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.filter-bar'); ?>
    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('Search name, email, subject')); ?>" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    <select name="read" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value=""><?php echo e(__('All')); ?></option>
        <option value="0" <?php echo e(request('read') === '0' ? 'selected' : ''); ?>><?php echo e(__('Unread')); ?></option>
        <option value="1" <?php echo e(request('read') === '1' ? 'selected' : ''); ?>><?php echo e(__('Read')); ?></option>
    </select>
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->make('components.admin.table', [
    'columns' => [
        ['label' => __('Name'), 'key' => 'name', 'sort_key' => 'name'],
        ['label' => __('Email'), 'key' => 'email', 'sort_key' => 'email'],
        ['label' => __('Subject'), 'key' => 'subject', 'limit' => 40, 'sort_key' => 'subject'],
        ['label' => __('Read'), 'key' => 'read_at', 'format' => 'boolean', 'sort_key' => 'read_at'],
        ['label' => __('Date'), 'key' => 'created_at', 'format' => 'datetime', 'sort_key' => 'created_at'],
    ],
    'rows' => $messages,
    'emptyMessage' => __('No messages yet.'),
    'actions' => [
        'view_route' => 'admin.contacts.show',
    ],
    'bulk_actions' => [
        ['value' => 'mark_read', 'label' => __('Mark as read')],
        ['value' => 'delete', 'label' => __('Delete')],
    ],
    'bulk_form_action' => route('admin.contacts.bulk'),
    'pagination' => $messages,
    'rowHighlightKey' => 'read_at',
    'rowHighlightClass' => 'bg-blue-50/50',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Contact\resources\views\admin\contacts\index.blade.php ENDPATH**/ ?>