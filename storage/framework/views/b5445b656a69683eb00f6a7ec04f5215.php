<?php $__env->startSection('title', __('Dashboard')); ?>
<?php $__env->startSection('heading', __('Dashboard')); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    
    <p class="text-gray-600"><?php echo e(__('Last 7 days')); ?> · <?php echo e(__('This month')); ?></p>

    
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <?php echo $__env->make('components.admin.stat-card', [
            'label' => __('Orders today'),
            'value' => number_format($ordersToday),
            'url' => route('admin.orders.index'),
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('components.admin.stat-card', [
            'label' => __('Orders this week'),
            'value' => number_format($ordersThisWeek),
            'url' => route('admin.orders.index'),
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('components.admin.stat-card', [
            'label' => __('Pending bank payments'),
            'value' => number_format($counts['pending_payments']),
            'url' => route('admin.payments.index'),
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('components.admin.stat-card', [
            'label' => __('Unread contact messages'),
            'value' => number_format($counts['unread_contacts']),
            'url' => route('admin.contacts.index'),
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('components.admin.stat-card', [
            'label' => __('Low stock products'),
            'value' => number_format($lowStockProducts->count()),
            'url' => route('admin.products.index'),
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gray-50/80 px-6 py-4">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500"><?php echo e(__('Total revenue')); ?></h2>
            </div>
            <div class="p-6">
                <p class="text-3xl font-bold text-gray-900"><?php echo e(number_format($totalRevenue, 2)); ?> <?php echo e(__('SAR')); ?></p>
            </div>
        </div>
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gray-50/80 px-6 py-4">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500"><?php echo e(__('Revenue')); ?> (<?php echo e(__('This month')); ?>)</h2>
            </div>
            <div class="p-6">
                <p class="text-3xl font-bold text-indigo-600"><?php echo e(number_format($revenueThisMonth, 2)); ?> <?php echo e(__('SAR')); ?></p>
            </div>
        </div>
    </div>

    
    <div class="grid gap-6 lg:grid-cols-2">
        
        <?php $__env->startComponent('components.admin.card', ['title' => __('Orders this week') . ' – ' . __('Last 7 days')]); ?>
            <div class="flex items-end justify-between gap-1 pt-4">
                <?php $maxDays = max(1, max($ordersLast7Days)); ?>
                <?php $__currentLoopData = $ordersLast7Days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex flex-1 flex-col items-center gap-1">
                        <span class="text-xs font-medium text-gray-500"><?php echo e(\Carbon\Carbon::parse($date)->format('D')); ?></span>
                        <div class="w-full rounded-t bg-indigo-500" style="height: <?php echo e(max(12, (int)(($count / $maxDays) * 120))); ?>px;" title="<?php echo e($count); ?>"></div>
                        <span class="text-sm font-semibold text-gray-900"><?php echo e($count); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php echo $__env->renderComponent(); ?>

        
        <?php $__env->startComponent('components.admin.card', ['title' => __('Low stock alerts')]); ?>
            <?php if($lowStockProducts->isEmpty()): ?>
                <p class="py-4 text-sm text-gray-500"><?php echo e(__('No low stock products.')); ?></p>
            <?php else: ?>
                <ul class="divide-y divide-gray-100">
                    <?php $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-center justify-between py-3 first:pt-0">
                            <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="font-medium text-gray-900 hover:text-indigo-600"><?php echo e($product->name); ?></a>
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold <?php echo e($product->stock === 0 ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800'); ?>"><?php echo e($product->stock); ?> <?php echo e(__('In stock')); ?></span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="mt-3 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800"><?php echo e(__('View all products')); ?></a>
            <?php endif; ?>
        <?php echo $__env->renderComponent(); ?>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        
        <?php $__env->startComponent('components.admin.card', ['title' => __('Top products')]); ?>
            <?php if($topProducts->isEmpty()): ?>
                <p class="py-4 text-sm text-gray-500"><?php echo e(__('No sales data yet.')); ?></p>
            <?php else: ?>
                <ul class="divide-y divide-gray-100">
                    <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-center justify-between py-3 first:pt-0">
                            <a href="<?php echo e(route('admin.products.edit', $item->product)); ?>" class="font-medium text-gray-900 hover:text-indigo-600"><?php echo e($item->product->name); ?></a>
                            <span class="text-sm font-semibold text-gray-600"><?php echo e(number_format($item->total_qty)); ?> <?php echo e(__('sold')); ?></span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        <?php echo $__env->renderComponent(); ?>

        
        <?php $__env->startComponent('components.admin.card', ['title' => __('Recent orders')]); ?>
            <?php if($recentOrders->isEmpty()): ?>
                <p class="py-4 text-sm text-gray-500"><?php echo e(__('No orders yet.')); ?></p>
            <?php else: ?>
                <?php echo $__env->make('components.admin.table', [
                    'columns' => [
                        ['label' => __('Order #'), 'key' => 'order_number', 'class' => 'font-mono'],
                        ['label' => __('Customer'), 'key' => 'user.name'],
                        ['label' => __('Total'), 'key' => 'total', 'format' => 'price'],
                        ['label' => __('Status'), 'key' => 'status', 'translate' => true],
                        ['label' => __('Date'), 'key' => 'created_at', 'format' => 'datetime'],
                    ],
                    'rows' => $recentOrders,
                    'emptyMessage' => __('No orders yet.'),
                    'actions' => ['view_route' => 'admin.orders.show'],
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="mt-3 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800"><?php echo e(__('View all orders')); ?></a>
            <?php endif; ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Core\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>