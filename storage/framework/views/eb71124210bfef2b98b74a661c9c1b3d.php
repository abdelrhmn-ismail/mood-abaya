

<?php $__env->startSection('title', __('Payment') . ' #' . $payment->id); ?>
<?php $__env->startSection('heading', ''); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <div class="flex flex-wrap items-center gap-4 rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm">
        <span class="flex items-center gap-2 text-sm text-gray-600">
            <span class="material-icons text-xl text-gray-400">payment</span>
            <strong class="text-gray-900"><?php echo e(__('Payment')); ?> #<?php echo e($payment->id); ?></strong>
        </span>
        <span class="rounded-full px-3 py-1 text-xs font-medium
            <?php if($payment->status === 'pending_approval'): ?> bg-brand-gold/30 text-brand-teal
            <?php else: ?> bg-gray-100 text-gray-800
            <?php endif; ?>">
            <?php echo e(payment_method_label($payment->method)); ?>

        </span>
        <span class="rounded-full px-3 py-1 text-xs font-medium
            <?php if($payment->status === 'paid'): ?> bg-green-100 text-green-800
            <?php elseif($payment->status === 'rejected'): ?> bg-red-100 text-red-800
            <?php elseif($payment->status === 'pending_approval'): ?> bg-amber-100 text-amber-800
            <?php else: ?> bg-gray-100 text-gray-800
            <?php endif; ?>">
            <?php echo e(ucfirst(str_replace('_', ' ', $payment->status ?? ''))); ?>

        </span>
        <span class="text-sm text-gray-500"><?php echo e($payment->created_at->format('M j, Y H:i')); ?></span>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        
        <?php $__env->startComponent('components.admin.card', ['title' => __('Payment details')]); ?>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                        <span class="material-icons">receipt_long</span>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Order')); ?></p>
                        <p class="mt-0.5 text-sm font-medium text-gray-900">
                            <?php if($payment->order): ?>
                                <a href="<?php echo e(route('admin.orders.show', $payment->order)); ?>" class="text-brand-teal hover:text-brand-teal-dark hover:underline"><?php echo e($payment->order->order_number); ?></a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-50 text-green-600">
                        <span class="material-icons">payments</span>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Method')); ?></p>
                        <p class="mt-0.5 text-sm font-medium text-gray-900"><?php echo e(payment_method_label($payment->method)); ?></p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                        <span class="material-icons">info</span>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Status')); ?></p>
                        <p class="mt-0.5 text-sm font-medium text-gray-900"><?php echo e(ucfirst(str_replace('_', ' ', $payment->status ?? ''))); ?></p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-sky-600">
                        <span class="material-icons">schedule</span>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Created')); ?></p>
                        <p class="mt-0.5 text-sm font-medium text-gray-900"><?php echo e($payment->created_at->format('M j, Y H:i')); ?></p>
                    </div>
                </div>
            </div>
        <?php echo $__env->renderComponent(); ?>

        
        <div class="space-y-6">
            <?php if($payment->proof_path): ?>
                <?php $__env->startComponent('components.admin.card', ['title' => __('Proof')]); ?>
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                            <span class="material-icons">attach_file</span>
                        </span>
                        <div class="min-w-0 flex-1">
                            <a href="<?php echo e(public_media_url($payment->proof_path)); ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-sm font-medium text-brand-teal hover:text-brand-teal-dark">
                                <span class="material-icons text-lg">open_in_new</span> <?php echo e(__('View proof')); ?>

                            </a>
                        </div>
                    </div>
                <?php echo $__env->renderComponent(); ?>
            <?php endif; ?>

            <?php $__env->startComponent('components.admin.card', ['title' => __('Actions')]); ?>
                <?php
                    $showMarkPaid = $payment->method === 'cash' && $payment->status !== 'paid';
                    $showApproveReject = $payment->status === 'pending_approval';
                ?>
                <?php if($showMarkPaid): ?>
                    <form action="<?php echo e(route('admin.payments.markPaid', $payment)); ?>" method="POST" class="mb-4">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-700">
                            <span class="material-icons text-lg">check_circle</span> <?php echo e(__('Mark as paid')); ?>

                        </button>
                    </form>
                <?php endif; ?>
                <?php if($showApproveReject): ?>
                    <div class="flex flex-wrap gap-3">
                        <form action="<?php echo e(route('admin.payments.approve', $payment)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-700">
                                <span class="material-icons text-lg">check</span> <?php echo e(__('Approve')); ?>

                            </button>
                        </form>
                        <form action="<?php echo e(route('admin.payments.reject', $payment)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-700">
                                <span class="material-icons text-lg">close</span> <?php echo e(__('Reject')); ?>

                            </button>
                        </form>
                    </div>
                <?php endif; ?>
                <?php if(!$showMarkPaid && !$showApproveReject): ?>
                    <p class="text-sm text-gray-500"><?php echo e(__('No actions available.')); ?></p>
                <?php endif; ?>
            <?php echo $__env->renderComponent(); ?>
        </div>
    </div>
</div>

<?php echo $__env->make('components.admin.back-link', ['url' => route('admin.payments.index'), 'text' => __('Back to payments')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Payment\resources\views\admin\payments\show.blade.php ENDPATH**/ ?>