<?php $__env->startSection('title', __('Order') . ' ' . $order->order_number . ' – ' . site_title()); ?>
<?php $__env->startSection('description', __('Order details')); ?>

<?php $__env->startSection('content'); ?>
<section class="bg-slate-50 py-16 md:py-20">
    <div class="container mx-auto max-w-4xl px-4">
        <h1 class="text-4xl font-bold text-slate-900"><?php echo e(__('Order')); ?> <?php echo e($order->order_number); ?></h1>

        <div class="mt-10 space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-slate-600"><strong><?php echo e(__('Date')); ?>:</strong> <?php echo e($order->created_at->format('Y-m-d H:i')); ?></p>
            <p class="text-slate-600"><strong><?php echo e(__('Status')); ?>:</strong> <?php echo e(__($order->status)); ?></p>
            <p class="text-slate-600"><strong><?php echo e(__('Payment')); ?>:</strong> <?php echo e(payment_method_label($order->payment_method)); ?> – <?php echo e(__($order->payment_status)); ?></p>

            <h2 class="mt-6 text-xl font-semibold text-slate-900"><?php echo e(__('Items')); ?></h2>
            <ul class="divide-y divide-slate-200">
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex justify-between py-3">
                        <span class="text-slate-900"><?php echo e($item->product?->name ?? '-'); ?> × <?php echo e($item->quantity); ?></span>
                        <span class="text-slate-600"><?php echo e(number_format($item->quantity * $item->price, 2)); ?> <?php echo e(__('SAR')); ?></span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <p class="border-t border-slate-200 pt-4 font-semibold text-slate-900"><?php echo e(__('Total')); ?>: <?php echo e(number_format($order->total, 2)); ?> <?php echo e(__('SAR')); ?></p>

            <?php if($order->shippings->isNotEmpty()): ?>
                <?php $shipping = $order->shippings->first(); ?>
                <div class="mt-6 border-t border-slate-200 pt-4">
                    <h2 class="text-xl font-semibold text-slate-900"><?php echo e(__('Shipping')); ?></h2>
                    <p class="text-slate-600"><?php echo e(__('Carrier')); ?>: <?php echo e($shipping->carrier); ?></p>
                    <p class="text-slate-600"><?php echo e(__('Tracking number')); ?>: <?php echo e($shipping->tracking_number); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <p class="mt-6"><a href="<?php echo e(route('account')); ?>" class="font-medium text-slate-700 hover:underline"><?php echo e(__('Back to account')); ?></a></p>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Order\resources\views\frontend\order-show.blade.php ENDPATH**/ ?>