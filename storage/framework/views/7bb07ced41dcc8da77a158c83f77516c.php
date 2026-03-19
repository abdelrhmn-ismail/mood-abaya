
<div x-data="{ open: false, product: null }"
     x-on:open-quick-view.window="product = $event.detail; open = true"
     x-on:keydown.escape.window="open = false"
     x-show="open"
     x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     style="display: none;">
    <div x-show="open" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         class="fixed inset-0 bg-black/60" @click="open = false"></div>
    <div x-show="open" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
         class="relative z-10 w-full max-w-lg overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl"
         @click.stop>
        <button type="button" @click="open = false" class="absolute right-3 top-3 rounded-full p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="<?php echo e(__('Close')); ?>">
            <span class="material-icons text-2xl">close</span>
        </button>
        <template x-if="product">
            <div class="p-6">
                <div class="flex gap-6">
                    <div class="h-48 w-48 shrink-0 overflow-hidden rounded-xl bg-slate-100">
                        <img :src="product.image" :alt="product.name" class="h-full w-full object-cover" x-show="product.image">
                        <span class="flex h-full w-full items-center justify-center text-slate-300 material-icons text-6xl" x-show="!product.image">inventory_2</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-xl font-bold text-slate-900" x-text="product.name"></h3>
                        <p class="mt-2 text-2xl font-bold text-brand-teal" x-text="(product.price || 0) + ' <?php echo e(__('SAR')); ?>'"></p>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <a :href="product.url" class="inline-flex items-center gap-1.5 rounded-xl border-2 border-brand-teal px-4 py-2.5 text-sm font-semibold text-brand-teal hover:bg-brand-teal hover:text-white">
                                <?php echo e(__('View product')); ?>

                            </a>
                            <form :action="'<?php echo e(route('cart.store')); ?>'" method="POST" class="inline" data-ajax-cart>
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" :value="product.id">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-brand-teal px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-teal-dark" data-added-label="<?php echo e(__('In cart')); ?>">
                                    <span class="material-icons text-lg">shopping_cart</span>
                                    <span class="cart-btn-text"><?php echo e(__('Add to Cart')); ?></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views/frontend/partials/quick-view-modal.blade.php ENDPATH**/ ?>