<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product', 'showAddToCart' => true]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product', 'showAddToCart' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $cardImages = $product->getDisplayImages();
?>
<article class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-brand-white shadow-sm transition hover:shadow-xl hover:border-brand-teal/20" x-data="{ active: 0 }">
    <div class="absolute right-2 top-2 z-20 flex gap-1 product-card-actions" onclick="event.preventDefault(); event.stopPropagation();">
        <?php echo $__env->make('frontend.partials.wishlist-button', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="flex flex-col flex-1 min-h-0">
        <?php if($cardImages->isEmpty()): ?>
            <div class="aspect-square w-full shrink-0 flex items-center justify-center bg-slate-100">
                <span class="material-icons text-6xl text-slate-300">inventory_2</span>
            </div>
        <?php else: ?>
            <div class="relative aspect-square w-full shrink-0 overflow-hidden bg-slate-100">
                <?php $__currentLoopData = $cardImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="<?php echo e($product->name); ?>"
                         class="absolute inset-0 h-full w-full object-cover transition duration-300 group-hover:scale-105 <?php echo e($index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'); ?>"
                         :class="active === <?php echo e($index); ?> ? 'opacity-100 z-10' : 'opacity-0 z-0'"
                         loading="lazy">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($cardImages->count() > 1): ?>
                    <div class="absolute bottom-2 left-0 right-0 z-20 flex justify-center gap-1.5" onclick="event.preventDefault(); event.stopPropagation();">
                        <?php $__currentLoopData = $cardImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" class="h-1.5 w-1.5 rounded-full transition focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2"
                                    :class="active === <?php echo e($index); ?> ? 'bg-brand-teal scale-125' : 'bg-white/80 hover:bg-white'"
                                    @click.prevent="active = <?php echo e($index); ?>"
                                    aria-label="<?php echo e(__('Image')); ?> <?php echo e($index + 1); ?>"></button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="border-t border-slate-100 flex min-h-[7.5rem] flex-col p-5 transition group-hover:bg-brand-gold/5">
            <?php if($product->hasDiscount()): ?>
                <span class="inline-flex w-fit items-center gap-1 self-start rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-800">
                    <span class="material-icons text-lg">local_offer</span> <?php echo e(__('Save')); ?> <?php echo e($product->discountPercent()); ?>%
                </span>
            <?php else: ?>
                <span class="inline-block h-5" aria-hidden="true"></span>
            <?php endif; ?>
            <h2 class="mt-1 font-semibold text-brand-black group-hover:text-brand-teal line-clamp-2"><?php echo e($product->name); ?></h2>
            <div class="mt-2 flex flex-wrap items-baseline gap-1.5">
                <span class="text-lg font-bold text-brand-teal"><?php echo e(number_format($product->price, 2)); ?> <?php echo e(__('SAR')); ?></span>
                <?php if($product->hasDiscount()): ?>
                    <span class="text-sm text-slate-500 line-through"><?php echo e(number_format($product->compare_at_price, 2)); ?> <?php echo e(__('SAR')); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </a>
    <?php if($showAddToCart): ?>
        <?php
            $inCart = app(\Modules\Cart\Services\CartService::class)->hasInCart($product->id, null);
        ?>
        <div class="mt-auto shrink-0 border-t border-slate-100 p-4">
            <form action="<?php echo e(route('cart.store')); ?>" method="POST" data-ajax-cart data-in-cart="<?php echo e($inCart ? '1' : '0'); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand-teal py-3 text-sm font-semibold text-white transition hover:bg-brand-teal-dark disabled:opacity-70 disabled:cursor-not-allowed" data-ripple-light="true" data-added-label="<?php echo e(__('In cart')); ?>" <?php if($inCart): ?> disabled <?php endif; ?>>
                    <span class="cart-btn-text"><?php echo e($inCart ? __('In cart') : __('Add to Cart')); ?></span>
                </button>
            </form>
        </div>
    <?php endif; ?>
</article>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views/components/frontend/product-card.blade.php ENDPATH**/ ?>