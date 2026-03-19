<?php $__env->startSection('title', __('My Account') . ' – ' . config('app.name')); ?>
<?php $__env->startSection('description', __('My Account')); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.hero-header','data' => ['title' => __('My Account'),'subtitle' => __('From your account dashboard you can view your recent orders and edit your details.'),'setting' => 'hero_account']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.hero-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('My Account')),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('From your account dashboard you can view your recent orders and edit your details.')),'setting' => 'hero_account']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e)): ?>
<?php $attributes = $__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e; ?>
<?php unset($__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e)): ?>
<?php $component = $__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e; ?>
<?php unset($__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e); ?>
<?php endif; ?>

    <section class="bg-slate-50 py-10 md:py-14">
        <div class="container mx-auto max-w-6xl px-4 lg:px-6">
            <div x-data="{
                tab: 'dashboard',
                initFromHash() {
                    const h = window.location.hash.replace('#','');
                    if (['account-details', 'orders', 'dashboard', 'wishlist', 'cart', 'addresses'].includes(h)) this.tab = h;
                    const orderParam = new URLSearchParams(window.location.search).get('order');
                    if (orderParam) this.tab = 'orders';
                },
                applyHashFromUrl() {
                    const h = window.location.hash.replace('#','');
                    if (['account-details', 'orders', 'dashboard', 'wishlist', 'cart', 'addresses'].includes(h)) this.tab = h;
                }
            }" x-init="
                initFromHash();
                $watch('tab', value => { const h = value || 'dashboard'; if (window.location.hash.replace('#','') !== h) history.replaceState(null, '', '#' + h); });
            " @hashchange.window="applyHashFromUrl()" class="flex flex-col gap-6 rounded-2xl border border-slate-200 bg-white shadow-sm lg:flex-row">
                
                <aside class="w-full shrink-0 border-b border-slate-200 bg-slate-50/80 lg:w-56 lg:border-b-0 lg:border-r lg:rounded-l-2xl">
                    <nav class="flex flex-row gap-1 p-3 lg:flex-col lg:p-4" role="tablist">
                        <button type="button"
                                role="tab"
                                :aria-selected="tab === 'dashboard'"
                                @click="tab = 'dashboard'"
                                :class="tab === 'dashboard' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-white/60 hover:text-slate-900'"
                                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            <span class="material-icons text-base">dashboard</span>
                            <span><?php echo e(__('Dashboard')); ?></span>
                        </button>
                        <button type="button"
                                role="tab"
                                :aria-selected="tab === 'orders'"
                                @click="tab = 'orders'"
                                :class="tab === 'orders' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-white/60 hover:text-slate-900'"
                                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            <span class="material-icons text-base">receipt_long</span>
                            <span><?php echo e(__('Orders')); ?></span>
                        </button>
                        <button type="button"
                                role="tab"
                                :aria-selected="tab === 'cart'"
                                @click="tab = 'cart'"
                                :class="tab === 'cart' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-white/60 hover:text-slate-900'"
                                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            <span class="material-icons text-base">shopping_cart</span>
                            <span><?php echo e(__('Cart')); ?></span>
                        </button>
                        <button type="button"
                                role="tab"
                                :aria-selected="tab === 'wishlist'"
                                @click="tab = 'wishlist'"
                                :class="tab === 'wishlist' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-white/60 hover:text-slate-900'"
                                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            <span class="material-icons text-base">favorite</span>
                            <span><?php echo e(__('Wishlist')); ?></span>
                        </button>
                        <button type="button"
                                role="tab"
                                :aria-selected="tab === 'addresses'"
                                @click="tab = 'addresses'"
                                :class="tab === 'addresses' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-white/60 hover:text-slate-900'"
                                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            <span class="material-icons text-base">location_on</span>
                            <span><?php echo e(__('Addresses')); ?></span>
                        </button>
                        <button type="button"
                                role="tab"
                                :aria-selected="tab === 'account-details'"
                                @click="tab = 'account-details'"
                                :class="tab === 'account-details' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-white/60 hover:text-slate-900'"
                                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            <span class="material-icons text-base">manage_accounts</span>
                            <span><?php echo e(__('Account details')); ?></span>
                        </button>
                    </nav>
                    <div class="border-t border-slate-200 p-3 lg:p-4">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="flex w-full items-center gap-2 rounded-xl px-4 py-2.5 text-left text-sm font-medium text-slate-600 transition hover:bg-red-50 hover:text-red-600">
                                <span class="material-icons text-base">logout</span>
                                <span><?php echo e(__('Log Out')); ?></span>
                            </button>
                        </form>
                    </div>
                </aside>

                
                <div class="min-w-0 flex-1 p-6 md:p-8">
                    <div x-show="tab === 'dashboard'" x-cloak role="tabpanel" id="tab-dashboard">
                        <?php echo $__env->make('user::frontend.account.dashboard-tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <div x-show="tab === 'orders'" x-cloak role="tabpanel" id="tab-orders">
                        <?php echo $__env->make('user::frontend.account.orders-tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <div x-show="tab === 'cart'" x-cloak role="tabpanel" id="tab-cart">
                        <?php echo $__env->make('user::frontend.account.cart-tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <div x-show="tab === 'wishlist'" x-cloak role="tabpanel" id="tab-wishlist">
                        <?php echo $__env->make('user::frontend.account.wishlist-tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <div x-show="tab === 'addresses'" x-cloak role="tabpanel" id="tab-addresses">
                        <?php echo $__env->make('user::frontend.account.addresses-tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <div x-show="tab === 'account-details'" x-cloak role="tabpanel" id="tab-account-details">
                        <?php echo $__env->make('user::frontend.account.account-details-tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/User\resources/views/frontend/account.blade.php ENDPATH**/ ?>