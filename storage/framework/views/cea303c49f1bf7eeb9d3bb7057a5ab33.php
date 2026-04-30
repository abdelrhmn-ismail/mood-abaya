<?php $__env->startSection('title', __('Order Confirmed') . ' – ' . site_title()); ?>
<?php $__env->startSection('description', __('Order Confirmed')); ?>

<?php $__env->startSection('content'); ?>
    <section class="bg-slate-50 py-16 md:py-20">
        <div class="container mx-auto max-w-2xl px-4">
            <?php if(session('success')): ?>
                <div class="mb-6 rounded-xl bg-green-100 px-4 py-3 text-green-800"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="mb-6 rounded-xl bg-amber-100 px-4 py-3 text-amber-800"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-sm">
                <span class="material-icons text-7xl text-green-500">check_circle</span>
                <h1 class="mt-4 text-3xl font-bold text-slate-900"><?php echo e(__('Order Confirmed')); ?></h1>
                <p class="mt-2 text-slate-600"><?php echo e(__('Thank you for your order. We will contact you shortly.')); ?></p>
                <p class="mt-4 font-mono text-lg font-semibold text-slate-900"><?php echo e($order->order_number); ?></p>
                <p class="mt-1 text-sm text-slate-500"><?php echo e(__('Total')); ?>: <?php echo e(number_format($order->total, 2)); ?> <?php echo e(__('SAR')); ?> · <?php echo e(__('Payment')); ?>: <?php echo e(payment_method_label($order->payment_method)); ?></p>

                <?php if($order->payment_status === 'pending_approval'): ?>
                    <p class="mt-6 text-sm text-slate-600"><?php echo e(__('We have received your payment proof. Our team will confirm and process your order.')); ?></p>
                <?php elseif($order->payment_method === 'tabby' && $order->payment_status === 'pending'): ?>
                    <p class="mt-6 text-sm text-slate-600"><?php echo e(__('Your Tabby payment is being processed. You will receive a confirmation once payment is complete.')); ?></p>
                <?php elseif($order->payment_method === 'cash'): ?>
                    <p class="mt-6 text-sm text-slate-600"><?php echo e(__('Pay when you receive your order.')); ?></p>
                <?php else: ?>
                    <p class="mt-6 text-sm text-slate-600"><?php echo e(__('Thank you for your order.')); ?></p>
                <?php endif; ?>

                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="<?php echo e(route('account')); ?>" class="rounded-xl bg-brand-teal px-6 py-3 font-semibold text-white hover:bg-brand-teal-dark"><?php echo e(__('View in Account')); ?></a>
                    <a href="<?php echo e(route('categories')); ?>" class="rounded-xl border border-slate-300 px-6 py-3 font-medium text-slate-700 hover:bg-slate-50"><?php echo e(__('Continue Shopping')); ?></a>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/Order\resources/views/frontend/order-confirmed.blade.php ENDPATH**/ ?>