<?php $__env->startSection('title', __('Payments')); ?>
<?php $__env->startSection('heading', __('Payments')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.filter-bar'); ?>
    <select name="status" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <option value=""><?php echo e(__('All statuses')); ?></option>
        <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>><?php echo e(__('pending')); ?></option>
        <option value="pending_approval" <?php echo e(request('status') === 'pending_approval' ? 'selected' : ''); ?>><?php echo e(__('pending_approval')); ?></option>
        <option value="paid" <?php echo e(request('status') === 'paid' ? 'selected' : ''); ?>><?php echo e(__('paid')); ?></option>
        <option value="rejected" <?php echo e(request('status') === 'rejected' ? 'selected' : ''); ?>><?php echo e(__('rejected')); ?></option>
    </select>
    <select name="method" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <option value=""><?php echo e(__('All methods')); ?></option>
        <option value="cash" <?php echo e(request('method') === 'cash' ? 'selected' : ''); ?>>cash</option>
        <option value="bank" <?php echo e(request('method') === 'bank' ? 'selected' : ''); ?>>bank</option>
    </select>
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->make('components.admin.table', [
    'columns' => [
        ['label' => __('ID'), 'key' => 'id', 'sort_key' => 'id'],
        ['label' => __('Order'), 'key' => 'order.order_number', 'class' => 'font-mono'],
        ['label' => __('Method'), 'key' => 'method', 'sort_key' => 'method'],
        ['label' => __('Status'), 'key' => 'status', 'sort_key' => 'status'],
        ['label' => __('Date'), 'key' => 'created_at', 'format' => 'datetime', 'sort_key' => 'created_at'],
    ],
    'rows' => $payments,
    'emptyMessage' => __('No payments found.'),
    'actions' => [
        'view_route' => 'admin.payments.show',
    ],
    'bulk_actions' => [
        ['value' => 'approve', 'label' => __('Approve (bank pending)')],
        ['value' => 'reject', 'label' => __('Reject (bank pending)')],
        ['value' => 'mark_paid', 'label' => __('Mark as paid')],
    ],
    'bulk_form_action' => route('admin.payments.bulk'),
    'pagination' => $payments,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/Payment\resources/views/admin/payments/index.blade.php ENDPATH**/ ?>