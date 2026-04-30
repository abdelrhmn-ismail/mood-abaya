
<div class="space-y-6">
    <?php if(session('success')): ?>
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-slate-900"><?php echo e(__('My Cart')); ?></h2>
        <p class="text-sm text-slate-600">
            <?php echo e(count($cartItems ?? [])); ?> <?php echo e(count($cartItems ?? []) === 1 ? __('item') : __('items')); ?>

            <?php if(isset($cartTotal) && $cartTotal > 0): ?>
                · <?php echo e(__('Total')); ?>: <?php echo e(number_format($cartTotal, 2)); ?> <?php echo e(__('SAR')); ?>

            <?php endif; ?>
        </p>
    </div>

    <?php if(isset($cartItems) && $cartItems->isNotEmpty()): ?>
        <ul class="grid grid-cols-1 gap-0 divide-y divide-slate-200">
            <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $product = $item->product; ?>
                <?php if($product): ?>
                    <li class="flex flex-col gap-4 py-4 sm:flex-row sm:items-center sm:gap-6">
                        <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-slate-100 sm:h-24 sm:w-24">
                            <?php if($product->image): ?>
                                <img src="<?php echo e(get_image_url($product->image)); ?>" alt="<?php echo e($product->name); ?>" class="h-full w-full object-cover">
                            <?php else: ?>
                                <span class="flex h-full w-full items-center justify-center text-slate-400">
                                    <span class="material-icons text-4xl">inventory_2</span>
                                </span>
                            <?php endif; ?>
                        </a>
                        <div class="min-w-0 flex-1">
                            <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="font-semibold text-slate-900 hover:underline"><?php echo e($product->name); ?></a>
                            <?php if($item->productVariant): ?>
                                <p class="mt-0.5 text-xs text-slate-500"><?php echo e($item->productVariant->getDisplayName()); ?></p>
                            <?php endif; ?>
                            <p class="mt-0.5 text-sm text-slate-500"><?php echo e(number_format($item->getEffectivePrice(), 2)); ?> <?php echo e(__('SAR')); ?> <?php echo e(__('each')); ?></p>
                            <p class="mt-1 font-semibold text-slate-800"><?php echo e(__('Qty')); ?>: <?php echo e($item->quantity); ?> · <?php echo e(number_format($item->getEffectivePrice() * $item->quantity, 2)); ?> <?php echo e(__('SAR')); ?></p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 shrink-0">
                            <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST" class="flex items-center gap-2">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="number" name="quantity" value="<?php echo e($item->quantity); ?>" min="1" max="999" class="w-16 rounded-lg border border-slate-300 px-2 py-1.5 text-center text-sm text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                                <button type="submit" class="rounded-lg px-2 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-100"><?php echo e(__('Update')); ?></button>
                            </form>
                            <form action="<?php echo e(route('cart.destroy', $item->id)); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('Remove this item?')); ?>');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg p-2 text-red-600 hover:bg-red-50" aria-label="<?php echo e(__('Remove')); ?>">
                                    <span class="material-icons text-xl">delete</span>
                                </button>
                            </form>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <div class="flex flex-col gap-4 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-xl font-bold text-slate-900"><?php echo e(__('Total')); ?>: <?php echo e(number_format($cartTotal ?? 0, 2)); ?> <?php echo e(__('SAR')); ?></p>
            <div class="flex flex-wrap gap-3">
                <a href="<?php echo e(route('categories')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-2.5 font-medium text-slate-700 transition hover:bg-slate-50">
                    <?php echo e(__('Continue Shopping')); ?>

                </a>
                <a href="<?php echo e(route('checkout')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-brand-teal px-6 py-2.5 font-semibold text-white transition hover:bg-brand-teal-dark">
                    <?php echo e(__('Checkout')); ?>

                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-12 text-center">
            <span class="material-icons text-6xl text-slate-300">shopping_cart</span>
            <p class="mt-4 font-medium text-slate-700"><?php echo e(__('Your cart is empty')); ?></p>
            <p class="mt-1 text-sm text-slate-500"><?php echo e(__('Add items from the shop to see them here.')); ?></p>
            <a href="<?php echo e(route('categories')); ?>" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-teal px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-teal-dark">
                <?php echo e(__('Browse categories')); ?>

            </a>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/User\resources/views/frontend/account/cart-tab.blade.php ENDPATH**/ ?>