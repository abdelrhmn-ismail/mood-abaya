
<div class="space-y-6">
    <?php if(isset($selectedOrder) && $selectedOrder): ?>
        <?php
            $statusSteps = ['pending' => 1, 'processing' => 2, 'shipped' => 3, 'delivered' => 4];
            $currentStep = $statusSteps[strtolower($selectedOrder->status)] ?? 1;
        ?>
        <?php if(session('success')): ?>
            <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"><?php echo e(session('error')); ?></div>
        <?php endif; ?>
        
        <a href="<?php echo e(route('account')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900">
            <span class="material-icons text-lg">arrow_back</span>
            <?php echo e(__('Back to orders list')); ?>

        </a>

        
        <div class="animate-order-detail overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-br from-slate-50 to-white px-6 py-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-teal text-white">
                            <span class="material-icons text-2xl">receipt_long</span>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900"><?php echo e(__('Order')); ?> <?php echo e($selectedOrder->order_number); ?></h2>
                            <p class="mt-0.5 text-sm text-slate-500"><?php echo e($selectedOrder->created_at->format('d M Y, H:i')); ?></p>
                        </div>
                    </div>
                    <span class="rounded-full px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wide
                        <?php if($selectedOrder->status === 'pending'): ?> bg-amber-100 text-amber-800
                        <?php elseif($selectedOrder->status === 'processing'): ?> bg-blue-100 text-blue-800
                        <?php elseif($selectedOrder->status === 'shipped'): ?> bg-indigo-100 text-indigo-800
                        <?php elseif($selectedOrder->status === 'delivered'): ?> bg-emerald-100 text-emerald-800
                        <?php else: ?> bg-slate-100 text-slate-700 <?php endif; ?>">
                        <?php echo e(__($selectedOrder->status)); ?>

                    </span>
                </div>
                
                <div class="mt-6 flex items-center gap-2" role="list" aria-label="<?php echo e(__('Order progress')); ?>">
                    <?php $__currentLoopData = ['pending' => ['schedule', __('Pending')], 'processing' => ['sync', __('Processing')], 'shipped' => ['local_shipping', __('Shipped')], 'delivered' => ['check_circle', __('Delivered')]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stepKey => $stepLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $stepNum = $statusSteps[$stepKey] ?? 0; $isDone = $currentStep > $stepNum; $isCurrent = $currentStep === $stepNum; ?>
                        <div class="flex flex-1 items-center" role="listitem">
                            <div class="flex flex-col items-center gap-1.5">
                                <div class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2 transition-all duration-300
                                    <?php if($isDone): ?> border-emerald-500 bg-emerald-500 text-white
                                    <?php elseif($isCurrent): ?> border-slate-900 bg-brand-teal text-white ring-4 ring-slate-900/20
                                    <?php else: ?> border-slate-200 bg-white text-slate-400 <?php endif; ?>">
                                    <?php if($isDone): ?>
                                        <span class="material-icons text-lg">check</span>
                                    <?php else: ?>
                                        <span class="material-icons text-lg"><?php echo e($stepLabel[0]); ?></span>
                                    <?php endif; ?>
                                </div>
                                <span class="text-xs font-medium <?php if($isCurrent): ?> text-slate-900 <?php elseif($isDone): ?> text-emerald-700 <?php else: ?> text-slate-400 <?php endif; ?>"><?php echo e($stepLabel[1]); ?></span>
                            </div>
                            <?php if(!$loop->last): ?>
                                <div class="mx-1 h-0.5 min-w-[12px] flex-1 rounded-full transition-all duration-500 <?php if($isDone): ?> bg-emerald-500 <?php else: ?> bg-slate-200 <?php endif; ?>"></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="grid gap-4 p-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="flex items-center gap-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-200/80 text-slate-600">
                        <span class="material-icons">event</span>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500"><?php echo e(__('Date')); ?></p>
                        <p class="mt-0.5 font-semibold text-slate-900"><?php echo e($selectedOrder->created_at->format('d M Y')); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-200/80 text-slate-600">
                        <span class="material-icons">payments</span>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500"><?php echo e(__('Payment')); ?></p>
                        <p class="mt-0.5 font-semibold text-slate-900"><?php echo e(__($selectedOrder->payment_method)); ?> · <?php echo e(__($selectedOrder->payment_status)); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4 sm:col-span-2 lg:col-span-1">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-200/80 text-slate-600">
                        <span class="material-icons">shopping_bag</span>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500"><?php echo e(__('Items')); ?></p>
                        <p class="mt-0.5 font-semibold text-slate-900"><?php echo e($selectedOrder->items->count()); ?> <?php echo e($selectedOrder->items->count() === 1 ? __('item') : __('items')); ?></p>
                    </div>
                </div>
            </div>

            
            <div class="border-t border-slate-100 px-6 pb-6">
                <h3 class="mb-4 flex items-center gap-2 pt-6 text-base font-semibold text-slate-900">
                    <span class="material-icons text-slate-600">inventory_2</span>
                    <?php echo e(__('Items')); ?>

                </h3>
                <?php $reviewedIds = $reviewedProductIds ?? []; ?>
                <ul class="space-y-3">
                    <?php $__currentLoopData = $selectedOrder->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm transition hover:border-slate-200 hover:shadow">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="h-12 w-12 shrink-0 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                        <span class="material-icons">inventory</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-900 truncate"><?php echo e($item->product?->name ?? '-'); ?></p>
                                        <p class="text-sm text-slate-500"><?php echo e(__('Qty')); ?>: <?php echo e($item->quantity); ?> × <?php echo e(number_format($item->price, 2)); ?> <?php echo e(__('SAR')); ?></p>
                                    </div>
                                </div>
                                <span class="shrink-0 font-semibold text-slate-900"><?php echo e(number_format($item->quantity * $item->price, 2)); ?> <?php echo e(__('SAR')); ?></span>
                            </div>
                            <?php if($selectedOrder->status === 'delivered'): ?>
                                <?php if(in_array($item->product_id, $reviewedIds)): ?>
                                    <p class="mt-3 flex items-center gap-2 text-sm text-emerald-600">
                                        <span class="material-icons text-lg">check_circle</span>
                                        <?php echo e(__('Reviewed')); ?>

                                    </p>
                                <?php else: ?>
                                    <form action="<?php echo e(route('account.order-review.store')); ?>" method="POST" class="mt-4 border-t border-slate-100 pt-4" x-data="{ hover: 0, selected: 5 }" @change="if ($event.target.name === 'rating') selected = parseInt($event.target.value)">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="order_id" value="<?php echo e($selectedOrder->id); ?>">
                                        <input type="hidden" name="product_id" value="<?php echo e($item->product_id); ?>">
                                        <p class="mb-2 text-sm font-medium text-slate-700"><?php echo e(__('Add review')); ?></p>
                                        <div class="flex flex-wrap items-center gap-4">
                                            <div class="flex items-center gap-1" role="group" aria-label="<?php echo e(__('Rating')); ?>">
                                                <?php for($r = 1; $r <= 5; $r++): ?>
                                                    <label class="cursor-pointer focus-within:text-amber-500 transition-colors"
                                                           @mouseenter="hover = <?php echo e($r); ?>"
                                                           @mouseleave="hover = 0"
                                                           :class="<?php echo e($r); ?> <= (hover || selected) ? 'text-amber-400' : 'text-slate-300'">
                                                        <input type="radio" name="rating" value="<?php echo e($r); ?>" class="sr-only" <?php echo e($r == 5 ? 'checked' : ''); ?>>
                                                        <span class="material-icons text-2xl">star</span>
                                                    </label>
                                                <?php endfor; ?>
                                            </div>
                                            <input type="text" name="comment" placeholder="<?php echo e(__('Your comment (optional)')); ?>" maxlength="2000" class="min-w-[200px] flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                            <button type="submit" class="rounded-xl bg-brand-teal px-4 py-2 text-sm font-medium text-white hover:bg-brand-teal-dark"><?php echo e(__('Submit review')); ?></button>
                                        </div>
                                        <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <div class="mt-4 flex items-center justify-between rounded-xl bg-brand-teal px-5 py-4 text-white">
                    <span class="font-semibold"><?php echo e(__('Total')); ?></span>
                    <span class="text-xl font-bold"><?php echo e(number_format($selectedOrder->total, 2)); ?> <?php echo e(__('SAR')); ?></span>
                </div>
            </div>

            <?php if($selectedOrder->shippings->isNotEmpty()): ?>
                <?php $shipping = $selectedOrder->shippings->first(); ?>
                <div class="border-t border-slate-100 px-6 py-6">
                    <h3 class="mb-4 flex items-center gap-2 text-base font-semibold text-slate-900">
                        <span class="material-icons rounded-lg bg-indigo-100 p-1.5 text-indigo-600">local_shipping</span>
                        <?php echo e(__('Shipping')); ?>

                    </h3>
                    <div class="flex flex-wrap gap-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-500"><?php echo e(__('Carrier')); ?></p>
                            <p class="mt-0.5 font-medium text-slate-900"><?php echo e($shipping->carrier); ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-500"><?php echo e(__('Tracking number')); ?></p>
                            <p class="mt-0.5 font-mono font-medium text-slate-900"><?php echo e($shipping->tracking_number); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        
        <h2 class="text-lg font-semibold text-slate-900"><?php echo e(__('Order History')); ?></h2>
        <?php if($orders->isEmpty()): ?>
            <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-12 text-center">
                <span class="material-icons text-6xl text-slate-300">receipt_long</span>
                <p class="mt-4 font-medium text-slate-700"><?php echo e(__('No orders yet.')); ?></p>
                <p class="mt-1 text-sm text-slate-500"><?php echo e(__('When you place an order, it will appear here.')); ?></p>
                <a href="<?php echo e(route('categories')); ?>" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-teal px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-teal-dark">
                    <?php echo e(__('Browse categories')); ?>

                </a>
            </div>
        <?php else: ?>
            <ul class="space-y-4">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-4 last:border-0">
                        <span class="font-mono text-sm font-medium text-slate-900"><?php echo e($order->order_number); ?></span>
                        <span class="text-sm text-slate-500"><?php echo e($order->created_at->format('Y-m-d')); ?></span>
                        <span class="rounded-lg px-2.5 py-1 text-xs font-medium
                            <?php if($order->status === 'pending'): ?> bg-amber-100 text-amber-800
                            <?php elseif($order->status === 'delivered' || $order->status === 'shipped'): ?> bg-green-100 text-green-800
                            <?php else: ?> bg-slate-100 text-slate-700 <?php endif; ?>">
                            <?php echo e(__($order->status)); ?>

                        </span>
                        <span class="font-semibold text-slate-900"><?php echo e(number_format($order->total, 2)); ?> <?php echo e(__('SAR')); ?></span>
                        <a href="<?php echo e(route('account', ['order' => $order->order_number])); ?>#orders" class="text-sm font-medium text-slate-700 underline hover:no-underline"><?php echo e(__('View')); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/User\resources/views/frontend/account/orders-tab.blade.php ENDPATH**/ ?>