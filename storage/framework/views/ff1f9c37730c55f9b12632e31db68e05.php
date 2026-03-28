<?php $__env->startSection('title', __('Order') . ' ' . $order->order_number); ?>
<?php $__env->startSection('heading', ''); ?>

<?php
    $shippingAddr = $order->shipping_address;
    if (is_string($shippingAddr)) {
        $shippingAddr = json_decode($shippingAddr, true) ?: [];
    }
    $billingAddr = $order->billing_address;
    if (is_string($billingAddr)) {
        $billingAddr = json_decode($billingAddr, true) ?: [];
    }
    $addressLine = function ($arr) {
        if (!is_array($arr)) return '';
        if (!empty($arr['address'])) {
            return $arr['address'] . (isset($arr['city']) ? ', ' . $arr['city'] : '');
        }
        $parts = array_filter([
            $arr['address_line_1'] ?? null,
            $arr['address_line_2'] ?? null,
            $arr['city'] ?? null,
            $arr['state'] ?? null,
            $arr['postal_code'] ?? null,
            $arr['country'] ?? null,
        ]);
        return implode(', ', $parts);
    };
?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <div class="flex flex-wrap items-center gap-4 rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm">
        <span class="flex items-center gap-2 text-sm text-gray-600">
            <span class="material-icons text-xl text-gray-400">tag</span>
            <strong class="text-gray-900"><?php echo e($order->order_number); ?></strong>
        </span>
        <span class="rounded-full px-3 py-1 text-xs font-medium
            <?php if($order->status === 'delivered'): ?> bg-green-100 text-green-800
            <?php elseif($order->status === 'cancelled'): ?> bg-red-100 text-red-800
            <?php elseif(in_array($order->status, ['shipped', 'processing'])): ?> bg-blue-100 text-blue-800
            <?php else: ?> bg-amber-100 text-amber-800
            <?php endif; ?>">
            <?php echo e(__($order->status)); ?>

        </span>
        <span class="text-sm text-gray-500"><?php echo e($order->created_at->format('M j, Y H:i')); ?></span>
        <span class="ml-auto text-lg font-semibold text-gray-900"><?php echo e(number_format($order->total, 2)); ?> <?php echo e(__('SAR')); ?></span>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        
        <div class="space-y-6">
            <?php $__env->startComponent('components.admin.card', ['title' => __('Customer & delivery')]); ?>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-gold/20 text-brand-teal">
                            <span class="material-icons">person</span>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Customer name')); ?></p>
                            <p class="mt-0.5 text-sm font-medium text-gray-900"><?php echo e($order->user?->name ?? '—'); ?></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                            <span class="material-icons">email</span>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Email')); ?></p>
                            <p class="mt-0.5 text-sm font-medium text-gray-900 break-all"><?php echo e($order->user?->email ?? '—'); ?></p>
                        </div>
                    </div>
                    <?php if(is_array($shippingAddr) && !empty($shippingAddr)): ?>
                        <div class="flex items-start gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                <span class="material-icons">phone</span>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Phone')); ?></p>
                                <p class="mt-0.5 text-sm font-medium text-gray-900"><?php echo e($shippingAddr['phone'] ?? $order->user?->phone ?? '—'); ?></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-sky-600">
                                <span class="material-icons">location_on</span>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Delivery address')); ?></p>
                                <p class="mt-0.5 text-sm text-gray-900"><?php echo e($shippingAddr['full_name'] ?? ''); ?><?php if(!empty($shippingAddr['full_name']) && $addressLine($shippingAddr)): ?><br><?php endif; ?><?php echo e($addressLine($shippingAddr) ?: '—'); ?></p>
                            </div>
                        </div>
                        <?php if(!empty($shippingAddr['notes'])): ?>
                            <div class="flex items-start gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                                    <span class="material-icons">note</span>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Order notes')); ?></p>
                                    <p class="mt-0.5 text-sm text-gray-700"><?php echo e($shippingAddr['notes']); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="flex items-start gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500">
                                <span class="material-icons">phone</span>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Phone')); ?></p>
                                <p class="mt-0.5 text-sm text-gray-900"><?php echo e($order->user?->phone ?? '—'); ?></p>
                            </div>
                        </div>
                        <?php if($order->shipping_address): ?>
                            <div class="flex items-start gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-sky-600">
                                    <span class="material-icons">location_on</span>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Address')); ?></p>
                                    <p class="mt-0.5 whitespace-pre-wrap text-sm text-gray-900"><?php echo e(is_string($order->shipping_address) ? $order->shipping_address : json_encode($order->shipping_address, JSON_UNESCAPED_UNICODE)); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php echo $__env->renderComponent(); ?>

            
            <?php if(is_array($billingAddr) && !empty($billingAddr)): ?>
                <?php $__env->startComponent('components.admin.card', ['title' => __('Billing address')]); ?>
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                            <span class="material-icons">receipt</span>
                        </span>
                        <div class="min-w-0 flex-1 text-sm text-gray-700">
                            <p class="font-medium text-gray-900"><?php echo e($billingAddr['full_name'] ?? '—'); ?></p>
                            <?php if(!empty($billingAddr['phone'])): ?><p class="mt-0.5"><?php echo e($billingAddr['phone']); ?></p><?php endif; ?>
                            <p class="mt-1 text-gray-600"><?php echo e($addressLine($billingAddr) ?: '—'); ?></p>
                        </div>
                    </div>
                <?php echo $__env->renderComponent(); ?>
            <?php endif; ?>
        </div>

        
        <div class="space-y-6">
            <?php $__env->startComponent('components.admin.card', ['title' => __('Order status')]); ?>
                <form action="<?php echo e(route('admin.orders.updateStatus', $order)); ?>" method="POST" class="flex flex-wrap items-center gap-3">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <span class="material-icons text-gray-400">swap_horiz</span>
                    <select name="status" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
                        <?php $__currentLoopData = ['pending','processing','shipped','delivered','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php echo e($order->status === $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"><?php echo e(__('Update status')); ?></button>
                </form>
            <?php echo $__env->renderComponent(); ?>

            <?php if($payment): ?>
                <?php $__env->startComponent('components.admin.card', ['title' => __('Payment')]); ?>
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-50 text-green-600">
                            <span class="material-icons">payment</span>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900"><?php echo e(ucfirst($payment->method)); ?></p>
                            <p class="text-xs text-gray-500"><?php echo e(ucfirst(str_replace('_', ' ', $payment->status ?? ''))); ?></p>
                        </div>
                    </div>
                    <?php if($payment->method === 'cash' && $payment->status !== 'paid'): ?>
                        <form action="<?php echo e(route('admin.payments.markPaid', $payment)); ?>" method="POST" class="mt-4">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                                <span class="material-icons text-lg">check_circle</span> <?php echo e(__('Mark as paid')); ?>

                            </button>
                        </form>
                    <?php endif; ?>
                    <?php if($payment->method === 'bank' && $payment->status === 'pending_approval'): ?>
                        <?php if($payment->proof_path): ?>
                            <p class="mt-3">
                                <a href="<?php echo e(public_media_url($payment->proof_path)); ?>" target="_blank" class="inline-flex items-center gap-1 text-sm text-brand-teal hover:text-brand-teal-dark">
                                    <span class="material-icons text-lg">attach_file</span> <?php echo e(__('View proof')); ?>

                                </a>
                            </p>
                        <?php endif; ?>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <form action="<?php echo e(route('admin.payments.approve', $payment)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                                    <span class="material-icons text-lg">check</span> <?php echo e(__('Approve')); ?>

                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.payments.reject', $payment)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                                    <span class="material-icons text-lg">close</span> <?php echo e(__('Reject')); ?>

                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                <?php echo $__env->renderComponent(); ?>
            <?php endif; ?>

            <?php $__env->startComponent('components.admin.card', ['title' => __('Shipping')]); ?>
                <?php if($order->shippings->isNotEmpty()): ?>
                    <?php $s = $order->shippings->first(); ?>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="material-icons text-gray-400">local_shipping</span>
                            <span class="text-sm font-medium text-gray-900"><?php echo e($s->carrier); ?></span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <span class="material-icons text-gray-400">pin</span>
                            <span><?php echo e($s->tracking_number); ?></span>
                        </div>
                        <?php if($s->shipped_at): ?>
                            <div class="flex items-center gap-3 text-sm text-gray-500">
                                <span class="material-icons text-gray-400">schedule</span>
                                <span><?php echo e($s->shipped_at->format('M j, Y H:i')); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <form action="<?php echo e(route('admin.orders.ship', $order)); ?>" method="POST" class="mt-4 space-y-3 border-t border-gray-200 pt-4">
                    <?php echo csrf_field(); ?>
                    <div class="flex flex-wrap gap-2">
                        <input type="text" name="carrier" placeholder="<?php echo e(__('Carrier')); ?>" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal" required>
                        <input type="text" name="tracking_number" placeholder="<?php echo e(__('Tracking number')); ?>" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal" required>
                    </div>
                    <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                        <span class="material-icons text-lg">local_shipping</span> <?php echo e(__('Mark as shipped')); ?>

                    </button>
                </form>
            <?php echo $__env->renderComponent(); ?>
        </div>
    </div>

    
    <?php $__env->startComponent('components.admin.card', ['title' => __('Items')]); ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Product')); ?></th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Qty')); ?></th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Price')); ?></th>
                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wide text-gray-500"><?php echo e(__('Total')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900"><?php echo e($item->product?->name ?? '—'); ?></td>
                            <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($item->quantity); ?></td>
                            <td class="px-4 py-3 text-sm text-gray-600"><?php echo e(number_format($item->price, 2)); ?> <?php echo e(__('SAR')); ?></td>
                            <td class="px-4 py-3 text-right text-sm font-medium text-gray-900"><?php echo e(number_format($item->quantity * $item->price, 2)); ?> <?php echo e(__('SAR')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex justify-end border-t border-gray-200 pt-4">
            <p class="text-lg font-semibold text-gray-900"><?php echo e(__('Total')); ?>: <?php echo e(number_format($order->total, 2)); ?> <?php echo e(__('SAR')); ?></p>
        </div>
    <?php echo $__env->renderComponent(); ?>
</div>

<?php echo $__env->make('components.admin.back-link', ['url' => route('admin.orders.index'), 'text' => __('Back to orders')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Order\resources\views\admin\orders\show.blade.php ENDPATH**/ ?>