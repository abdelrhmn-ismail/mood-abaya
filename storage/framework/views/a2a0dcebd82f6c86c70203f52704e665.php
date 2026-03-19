
<div class="space-y-6">
    <?php if(session('success')): ?>
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-slate-900"><?php echo e(__('My Wishlist')); ?></h2>
        <p class="text-sm text-slate-600"><?php echo e(count($wishlistItems ?? [])); ?> <?php echo e(count($wishlistItems ?? []) === 1 ? __('item') : __('items')); ?></p>
    </div>

    <?php if(isset($wishlistItems) && $wishlistItems->isNotEmpty()): ?>
        <ul class="grid grid-cols-1 gap-0 divide-y divide-slate-200">
            <?php $__currentLoopData = $wishlistItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $product = $item->product; ?>
                <?php if($product): ?>
                    <li class="flex flex-col gap-4 py-4 sm:flex-row sm:items-center sm:gap-6">
                        <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-slate-100 sm:h-24 sm:w-24">
                            <?php if($product->image): ?>
                                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" class="h-full w-full object-cover">
                            <?php else: ?>
                                <span class="flex h-full w-full items-center justify-center text-slate-400">
                                    <span class="material-icons text-4xl">inventory_2</span>
                                </span>
                            <?php endif; ?>
                        </a>
                        <div class="min-w-0 flex-1">
                            <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="font-semibold text-slate-900 hover:underline"><?php echo e($product->name); ?></a>
                            <?php if($product->category): ?>
                                <p class="mt-0.5 text-sm text-slate-500"><?php echo e($product->category->name); ?></p>
                            <?php endif; ?>
                            <p class="mt-1 text-lg font-bold text-slate-800"><?php echo e(number_format($product->price, 2)); ?> <?php echo e(__('SAR')); ?></p>
                        </div>
                        <div class="flex flex-wrap gap-2 shrink-0">
                            <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                <?php echo e(__('View')); ?>

                            </a>
                            <form action="<?php echo e(route('wishlist.destroy', $product->id)); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('Remove from wishlist?')); ?>');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-red-100 bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700 transition hover:bg-red-100">
                                    <span class="material-icons text-lg">favorite</span>
                                    <?php echo e(__('Remove')); ?>

                                </button>
                            </form>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php else: ?>
        <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-12 text-center">
            <span class="material-icons text-6xl text-slate-300">favorite_border</span>
            <p class="mt-4 font-medium text-slate-700"><?php echo e(__('Your wishlist is empty')); ?></p>
            <p class="mt-1 text-sm text-slate-500"><?php echo e(__('Save items you like by clicking the heart on product pages.')); ?></p>
            <a href="<?php echo e(route('categories')); ?>" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-teal px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-teal-dark">
                <?php echo e(__('Browse categories')); ?>

            </a>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/User\resources/views/frontend/account/wishlist-tab.blade.php ENDPATH**/ ?>