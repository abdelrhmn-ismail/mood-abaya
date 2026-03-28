
<div x-data="CartDrawer()" x-init="init()" @cart-drawer-open.window="open()" @cart-drawer-close.window="close()" @keydown.escape.window="close()">

    
    <div x-show="visible" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[60] bg-black/40 backdrop-blur-sm" @click="close()" x-cloak></div>

    
    <aside x-show="visible"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="<?php echo e(app()->getLocale() === 'ar' ? '-translate-x-full' : 'translate-x-full'); ?>"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="<?php echo e(app()->getLocale() === 'ar' ? '-translate-x-full' : 'translate-x-full'); ?>"
           class="fixed inset-y-0 <?php echo e(app()->getLocale() === 'ar' ? 'start-0' : 'end-0'); ?> z-[70] flex w-full max-w-md flex-col bg-brand-white shadow-2xl"
           x-cloak>

        
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
            <h2 class="flex items-center gap-2 text-lg font-bold text-brand-black">
                <span class="material-icons text-brand-teal">shopping_bag</span>
                <?php echo e(__('Shopping Bag')); ?>

                <span x-show="count > 0" x-text="'(' + count + ')'" class="text-sm font-normal text-slate-500"></span>
            </h2>
            <button @click="close()" class="rounded-full p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600" aria-label="<?php echo e(__('Close')); ?>">
                <span class="material-icons text-xl">close</span>
            </button>
        </div>

        
        <div x-show="loading && items.length === 0" class="flex flex-1 items-center justify-center">
            <span class="inline-flex h-8 w-8 animate-spin rounded-full border-4 border-brand-teal border-t-transparent"></span>
        </div>

        
        <div x-show="!loading && items.length === 0" class="flex flex-1 flex-col items-center justify-center gap-4 px-6 text-center">
            <span class="material-icons text-7xl text-slate-200">shopping_cart</span>
            <p class="text-lg font-medium text-slate-500"><?php echo e(__('Your cart is empty')); ?></p>
            <button @click="close()" class="rounded-xl bg-brand-teal px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-teal-dark">
                <?php echo e(__('Continue Shopping')); ?>

            </button>
        </div>

        
        <div x-show="items.length > 0" class="flex-1 overflow-y-auto overscroll-contain px-5 py-4 space-y-4" x-ref="itemsContainer">
            <template x-for="item in items" :key="item.id">
                <div class="group relative flex gap-4 rounded-xl border border-slate-100 bg-slate-50/50 p-3 transition hover:border-brand-teal/20 hover:shadow-sm">
                    
                    <a :href="'/products/' + item.product_slug" class="h-24 w-20 shrink-0 overflow-hidden rounded-lg bg-slate-100">
                        <template x-if="item.image">
                            <img :src="item.image" :alt="item.product_name" class="h-full w-full object-cover transition group-hover:scale-105" loading="lazy">
                        </template>
                        <template x-if="!item.image">
                            <span class="flex h-full w-full items-center justify-center">
                                <span class="material-icons text-3xl text-slate-300">inventory_2</span>
                            </span>
                        </template>
                    </a>

                    
                    <div class="flex min-w-0 flex-1 flex-col justify-between">
                        <div>
                            <a :href="'/products/' + item.product_slug" class="block truncate text-sm font-semibold text-brand-black hover:text-brand-teal" x-text="item.product_name"></a>
                            <p x-show="item.variant_name" x-text="item.variant_name" class="mt-0.5 truncate text-xs text-slate-500"></p>
                            <p class="mt-1 text-sm font-bold text-brand-teal">
                                <span x-text="parseFloat(item.price).toFixed(2)"></span>
                                <span class="text-xs font-normal"><?php echo e(__('SAR')); ?></span>
                            </p>
                        </div>

                        
                        <div class="mt-2 flex items-center gap-3">
                            <div class="inline-flex items-center rounded-lg border border-slate-200 bg-white">
                                <button @click="changeQty(item, -1)" :disabled="updating === item.id || item.quantity <= 1" class="flex h-8 w-8 items-center justify-center text-slate-500 transition hover:text-brand-teal disabled:opacity-40 disabled:cursor-not-allowed">
                                    <span class="material-icons text-lg">remove</span>
                                </button>
                                <span x-text="item.quantity" class="flex h-8 w-8 items-center justify-center text-sm font-semibold text-brand-black"></span>
                                <button @click="changeQty(item, 1)" :disabled="updating === item.id" class="flex h-8 w-8 items-center justify-center text-slate-500 transition hover:text-brand-teal disabled:opacity-40 disabled:cursor-not-allowed">
                                    <span class="material-icons text-lg">add</span>
                                </button>
                            </div>
                            <span class="text-xs text-slate-400">
                                <span x-text="parseFloat(item.line_total).toFixed(2)"></span> <?php echo e(__('SAR')); ?>

                            </span>
                        </div>
                    </div>

                    
                    <button @click="removeItem(item)" :disabled="updating === item.id" class="absolute end-2 top-2 rounded-full p-1 text-slate-300 transition hover:bg-red-50 hover:text-red-500 disabled:opacity-40" :title="'<?php echo e(__('Remove')); ?>'">
                        <span class="material-icons text-lg">close</span>
                    </button>
                </div>
            </template>
        </div>

        
        <div x-show="items.length > 0" class="border-t border-slate-200 bg-slate-50/80 px-5 py-4 space-y-3">
            <div class="flex items-center justify-between text-base">
                <span class="font-medium text-slate-600"><?php echo e(__('Subtotal')); ?></span>
                <span class="text-lg font-bold text-brand-black">
                    <span x-text="parseFloat(subtotal).toFixed(2)"></span>
                    <span class="text-sm font-normal text-slate-500"><?php echo e(__('SAR')); ?></span>
                </span>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo e(route('cart')); ?>" class="flex-1 rounded-xl border border-slate-200 bg-white py-3 text-center text-sm font-semibold text-brand-black transition hover:border-brand-teal hover:text-brand-teal">
                    <?php echo e(__('View Cart')); ?>

                </a>
                <a href="<?php echo e(route('checkout')); ?>" class="flex-1 rounded-xl bg-brand-teal py-3 text-center text-sm font-semibold text-white transition hover:bg-brand-teal-dark">
                    <?php echo e(__('Checkout')); ?>

                </a>
            </div>
            <button @click="close()" class="w-full py-2 text-center text-sm text-slate-500 transition hover:text-brand-teal">
                <?php echo e(__('Continue Shopping')); ?>

            </button>
        </div>
    </aside>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\components\frontend\cart-drawer.blade.php ENDPATH**/ ?>