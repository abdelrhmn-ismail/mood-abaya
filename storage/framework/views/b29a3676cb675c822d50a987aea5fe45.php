<?php $__env->startSection('title', __('Orders')); ?>
<?php $__env->startSection('heading', __('Orders')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.filter-bar'); ?>
    <input type="text" name="order_number" value="<?php echo e(request('order_number')); ?>" placeholder="<?php echo e(__('Order #')); ?>" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
    <select name="status" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <option value=""><?php echo e(__('All statuses')); ?></option>
        <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>><?php echo e(__('pending')); ?></option>
        <option value="processing" <?php echo e(request('status') === 'processing' ? 'selected' : ''); ?>><?php echo e(__('processing')); ?></option>
        <option value="shipped" <?php echo e(request('status') === 'shipped' ? 'selected' : ''); ?>><?php echo e(__('shipped')); ?></option>
        <option value="delivered" <?php echo e(request('status') === 'delivered' ? 'selected' : ''); ?>><?php echo e(__('delivered')); ?></option>
        <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>><?php echo e(__('cancelled')); ?></option>
    </select>
    <select name="payment_status" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <option value=""><?php echo e(__('All payment statuses')); ?></option>
        <option value="pending" <?php echo e(request('payment_status') === 'pending' ? 'selected' : ''); ?>><?php echo e(__('pending')); ?></option>
        <option value="pending_approval" <?php echo e(request('payment_status') === 'pending_approval' ? 'selected' : ''); ?>><?php echo e(__('pending_approval')); ?></option>
        <option value="paid" <?php echo e(request('payment_status') === 'paid' ? 'selected' : ''); ?>><?php echo e(__('paid')); ?></option>
        <option value="rejected" <?php echo e(request('payment_status') === 'rejected' ? 'selected' : ''); ?>><?php echo e(__('rejected')); ?></option>
    </select>
    <div class="flex items-center gap-2">
        <a href="<?php echo e(route('admin.orders.export', request()->query())); ?>" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50">
            <span class="material-icons text-lg">download</span> <?php echo e(__('Export CSV')); ?>

        </a>
        <a href="<?php echo e(route('admin.orders.export', array_merge(request()->query(), ['with_items' => 1]))); ?>" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50">
            <span class="material-icons text-lg">download</span> <?php echo e(__('Export CSV with items')); ?>

        </a>
    </div>
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->make('components.admin.table', [
    'columns' => [
        ['label' => __('Order #'), 'key' => 'order_number', 'class' => 'font-mono', 'sort_key' => 'order_number'],
        ['label' => __('Customer'), 'key' => 'user.name', 'sort_key' => 'user_name'],
        ['label' => __('Total'), 'key' => 'total', 'format' => 'price', 'sort_key' => 'total'],
        ['label' => __('Payment'), 'key' => 'payment_method', 'key2' => 'payment_status', 'glue' => ' / ', 'sort_key' => 'payment_status', 'translate' => true],
        ['label' => __('Status'), 'key' => 'status', 'sort_key' => 'status', 'translate' => true],
        ['label' => __('Date'), 'key' => 'created_at', 'format' => 'datetime', 'sort_key' => 'created_at'],
    ],
    'rows' => $orders,
    'emptyMessage' => __('No orders found.'),
    'actions' => [
        'view_route' => 'admin.orders.show',
    ],
    'bulk_actions' => [
        ['value' => 'pending', 'label' => __('Set status: Pending')],
        ['value' => 'processing', 'label' => __('Set status: Processing')],
        ['value' => 'shipped', 'label' => __('Set status: Shipped')],
        ['value' => 'delivered', 'label' => __('Set status: Delivered')],
        ['value' => 'cancelled', 'label' => __('Set status: Cancelled')],
    ],
    'bulk_form_action' => route('admin.orders.bulk'),
    'pagination' => $orders,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/Order\resources/views/admin/orders/index.blade.php ENDPATH**/ ?>