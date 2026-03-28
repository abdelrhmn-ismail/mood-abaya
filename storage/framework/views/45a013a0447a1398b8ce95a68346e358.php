<nav class="sticky top-0 z-50 border-b border-slate-200 bg-brand-white/95 shadow-sm backdrop-blur" id="main-navbar">
    <div class="container mx-auto flex flex-wrap items-center justify-between gap-3 px-4 py-3">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center shrink-0" aria-label="<?php echo e(site_label('site_name')); ?>">
            <?php if(site_logo_url()): ?>
                <img src="<?php echo e(site_logo_url()); ?>" alt="" class="h-9 w-auto max-w-[160px] object-contain md:h-10 md:max-w-[180px]">
            <?php else: ?>
                <span class="material-icons text-3xl text-brand-teal">storefront</span>
            <?php endif; ?>
        </a>

        <div class="hidden flex-1 items-center justify-center gap-4 md:flex" data-navbar="menu">
            <div class="flex items-center gap-6 lg:gap-8">
                <a href="<?php echo e(route('home')); ?>" class="text-sm font-medium text-brand-black/80 hover:text-brand-teal"><?php echo e(site_label('nav_home')); ?></a>
                <a href="<?php echo e(route('categories')); ?>" class="text-sm font-medium text-brand-black/80 hover:text-brand-teal"><?php echo e(site_label('nav_categories')); ?></a>
                <a href="<?php echo e(route('home')); ?>#products" class="text-sm font-medium text-brand-black/80 hover:text-brand-teal"><?php echo e(site_label('nav_products')); ?></a>
                <a href="<?php echo e(route('about')); ?>" class="text-sm font-medium text-brand-black/80 hover:text-brand-teal"><?php echo e(__('About Us')); ?></a>
                <a href="<?php echo e(route('blog.index')); ?>" class="text-sm font-medium text-brand-black/80 hover:text-brand-teal"><?php echo e(__('Blog')); ?></a>
                <a href="<?php echo e(route('contact')); ?>" class="text-sm font-medium text-brand-black/80 hover:text-brand-teal"><?php echo e(site_label('nav_contact')); ?></a>
            </div>
            <form action="<?php echo e(route('search')); ?>" method="GET" class="w-full min-w-0 max-w-[200px] lg:max-w-[240px]" role="search">
                <label for="nav-search" class="sr-only"><?php echo e(__('Search products')); ?></label>
                <div class="relative flex items-center">
                    <span class="pointer-events-none absolute start-3 flex items-center justify-center text-slate-400 inset-y-0">
                        <span class="material-icons text-lg leading-none">search</span>
                    </span>
                    <input type="search" name="q" id="nav-search" value="<?php echo e(request('q')); ?>" placeholder="<?php echo e(__('Search products')); ?>" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2 ps-10 pe-4 text-sm text-brand-black placeholder-slate-400 transition focus:border-brand-teal focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-teal/20">
                </div>
            </form>
        </div>

        <div class="hidden items-center gap-3 md:flex">
            
            <div class="relative" x-data="{ localeOpen: false }" @click.outside="localeOpen = false">
                <button type="button"
                        @click="localeOpen = !localeOpen"
                        class="flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10"
                        aria-haspopup="true"
                        :aria-expanded="localeOpen"
                        aria-label="<?php echo e(__('Language')); ?>">
                    <span class="material-icons text-lg">language</span>
                    <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': localeOpen }">expand_more</span>
                </button>
                <div x-show="localeOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute end-0 top-full z-50 mt-1 min-w-[140px] rounded-xl border border-slate-200 bg-brand-white py-1 shadow-lg" x-cloak style="display: none;">
                    <a href="<?php echo e(route('locale.switch', 'en')); ?>" class="flex items-center gap-2 px-4 py-2 text-sm text-brand-black/90 hover:bg-brand-gold/10 <?php echo e(app()->getLocale() === 'en' ? 'bg-brand-gold/20 font-medium' : ''); ?>">
                        <span class="fi fi-gb rounded-sm shadow-sm" style="width: 1.25rem; height: 0.875rem; background-size: cover;"></span>
                        <?php echo e(__('English')); ?>

                    </a>
                    <a href="<?php echo e(route('locale.switch', 'ar')); ?>" class="flex items-center gap-2 px-4 py-2 text-sm text-brand-black/90 hover:bg-brand-gold/10 <?php echo e(app()->getLocale() === 'ar' ? 'bg-brand-gold/20 font-medium' : ''); ?>">
                        <span class="fi fi-sa rounded-sm shadow-sm" style="width: 1.25rem; height: 0.875rem; background-size: cover;"></span>
                        <?php echo e(__('Arabic')); ?>

                    </a>
                </div>
            </div>
            <a href="<?php echo e(route('account')); ?>#wishlist" id="nav-wishlist-link" class="flex items-center gap-2 rounded-xl bg-brand-gold/15 px-4 py-2.5 text-sm font-medium text-brand-teal transition hover:bg-brand-gold/25" data-ripple-light="true" aria-label="<?php echo e(__('Wishlist')); ?>">
                <span class="material-icons text-xl">favorite</span>
                <span id="nav-wishlist-count" class="rounded-full bg-brand-teal px-2 py-0.5 text-xs text-white" style="<?php echo e((isset($wishlistCount) && $wishlistCount > 0) ? '' : 'display:none'); ?>"><?php echo e($wishlistCount ?? 0); ?></span>
            </a>
            <button type="button" id="nav-cart-link" onclick="window.dispatchEvent(new CustomEvent('cart-drawer-open'))" class="flex items-center gap-2 rounded-xl bg-brand-gold/15 px-4 py-2.5 text-sm font-medium text-brand-teal transition hover:bg-brand-gold/25 cursor-pointer" data-ripple-light="true" aria-label="<?php echo e(site_label('nav_cart')); ?>">
                <span class="material-icons text-xl">shopping_cart</span>
                <span id="nav-cart-count" class="rounded-full bg-brand-teal px-2 py-0.5 text-xs text-white" style="<?php echo e((isset($cartCount) && $cartCount > 0) ? '' : 'display:none'); ?>"><?php echo e($cartCount ?? 0); ?></span>
            </button>
            <?php if(auth()->guard()->check()): ?>
                
                <div class="relative" x-data="{ userMenuOpen: false }" @click.outside="userMenuOpen = false">
                    <button type="button"
                            @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10"
                            aria-haspopup="true"
                            :aria-expanded="userMenuOpen">
                        <span class="material-icons text-lg">person</span>
                        <span class="max-w-[9rem] truncate text-start">
                            <?php echo e(\Illuminate\Support\Str::limit(auth()->user()->name, 18)); ?>

                        </span>
                        <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': userMenuOpen }">expand_more</span>
                    </button>
                    <div x-show="userMenuOpen"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute end-0 top-full z-50 mt-1 min-w-[160px] rounded-xl border border-slate-200 bg-brand-white py-1 shadow-lg"
                         x-cloak
                         style="display: none;">
                        <?php if(auth()->user()->is_admin): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-4 py-2.5 text-sm text-brand-teal hover:bg-brand-gold/10 font-medium">
                                <?php echo e(__('Dashboard panel')); ?>

                            </a>
                            <a href="<?php echo e(route('admin.settings.frontend')); ?>" class="block px-4 py-2.5 text-sm text-brand-teal hover:bg-brand-gold/10 font-medium">
                                <?php echo e(__('Frontend settings')); ?>

                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('account')); ?>" class="block px-4 py-2.5 text-sm text-brand-black/90 hover:bg-brand-gold/10">
                                <?php echo e(site_label('nav_account')); ?>

                            </a>
                        <?php endif; ?>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="block w-full px-4 py-2.5 text-left text-sm text-brand-black/90 hover:bg-brand-gold/10">
                                <?php echo e(site_label('nav_logout')); ?>

                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                
                <div class="relative" x-data="{ accountOpen: false }" @click.outside="accountOpen = false">
                    <button type="button" @click="accountOpen = !accountOpen" class="flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10" aria-haspopup="true" :aria-expanded="accountOpen" aria-label="<?php echo e(site_label('nav_login')); ?>">
                        <span class="material-icons text-lg">person</span>
                        <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': accountOpen }">expand_more</span>
                    </button>
                    <div x-show="accountOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute end-0 top-full z-50 mt-1 min-w-[140px] rounded-xl border border-slate-200 bg-brand-white py-1 shadow-lg" x-cloak style="display: none;">
                        <a href="<?php echo e(route('login')); ?>" class="block px-4 py-2.5 text-sm text-brand-black/90 hover:bg-brand-gold/10"><?php echo e(site_label('nav_login')); ?></a>
                        <a href="<?php echo e(route('register')); ?>" class="block px-4 py-2.5 text-sm font-medium text-brand-teal hover:bg-brand-gold/10"><?php echo e(site_label('nav_register')); ?></a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        
        <button type="button" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-brand-teal hover:bg-brand-gold/10 md:hidden" aria-label="<?php echo e(__('Toggle menu')); ?>" aria-expanded="false" data-navbar="toggle" data-label-open="<?php echo e(__('Toggle menu')); ?>" data-label-close="<?php echo e(__('Close menu')); ?>">
            <span class="material-icons text-2xl leading-none select-none" data-navbar="toggle-icon" aria-hidden="true">menu</span>
        </button>
    </div>

    <div class="hidden w-full flex-col gap-1 border-t border-slate-200 bg-brand-white px-4 py-4 md:hidden" data-navbar="mobile-menu">
        <form action="<?php echo e(route('search')); ?>" method="GET" class="mb-2 w-full" role="search">
            <label for="nav-search-mobile" class="sr-only"><?php echo e(__('Search products')); ?></label>
<div class="relative flex items-center">
                <span class="pointer-events-none absolute start-3 flex items-center justify-center text-slate-400 inset-y-0">
                        <span class="material-icons text-lg leading-none">search</span>
                    </span>
                    <input type="search" name="q" id="nav-search-mobile" value="<?php echo e(request('q')); ?>" placeholder="<?php echo e(__('Search products')); ?>" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 ps-10 pe-4 text-sm text-brand-black placeholder-slate-400 focus:border-brand-teal focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-teal/20">
            </div>
        </form>
        <a href="<?php echo e(route('home')); ?>" class="rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10"><?php echo e(site_label('nav_home')); ?></a>
        <a href="<?php echo e(route('categories')); ?>" class="rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10"><?php echo e(site_label('nav_categories')); ?></a>
        <a href="<?php echo e(route('home')); ?>#products" class="rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10"><?php echo e(site_label('nav_products')); ?></a>
        <a href="<?php echo e(route('about')); ?>" class="rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10"><?php echo e(__('About Us')); ?></a>
        <a href="<?php echo e(route('blog.index')); ?>" class="rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10"><?php echo e(__('Blog')); ?></a>
        <a href="<?php echo e(route('contact')); ?>" class="rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10"><?php echo e(site_label('nav_contact')); ?></a>
        
        <div class="relative border-b border-slate-100 px-3 py-2" x-data="{ localeOpenMobile: false }" @click.outside="localeOpenMobile = false">
            <button type="button" @click="localeOpenMobile = !localeOpenMobile" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10">
                <span><?php echo e(__('Language')); ?>: <?php echo e(app()->getLocale() === 'ar' ? __('Arabic') : __('English')); ?></span>
                <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': localeOpenMobile }">expand_more</span>
            </button>
            <div x-show="localeOpenMobile" x-transition class="mt-1 space-y-0.5 ps-2">
                <a href="<?php echo e(route('locale.switch', 'en')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(app()->getLocale() === 'en' ? 'bg-brand-gold/20 font-medium text-brand-teal' : 'text-brand-black/80 hover:bg-brand-gold/10'); ?>">
                    <span class="fi fi-gb rounded-sm shadow-sm" style="width: 1.125rem; height: 0.75rem; background-size: cover;"></span>
                    <?php echo e(__('English')); ?>

                </a>
                <a href="<?php echo e(route('locale.switch', 'ar')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(app()->getLocale() === 'ar' ? 'bg-brand-gold/20 font-medium text-brand-teal' : 'text-brand-black/80 hover:bg-brand-gold/10'); ?>">
                    <span class="fi fi-sa rounded-sm shadow-sm" style="width: 1.125rem; height: 0.75rem; background-size: cover;"></span>
                    <?php echo e(__('Arabic')); ?>

                </a>
            </div>
        </div>
        <a href="<?php echo e(route('account')); ?>#wishlist" id="nav-wishlist-link-mobile" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-brand-teal hover:bg-brand-gold/10">
            <span class="material-icons text-lg">favorite</span>
            <?php echo e(__('Wishlist')); ?>

            <span id="nav-wishlist-count-mobile" class="rounded-full bg-brand-teal px-2 py-0.5 text-xs text-white" style="<?php echo e((isset($wishlistCount) && $wishlistCount > 0) ? '' : 'display:none'); ?>"><?php echo e($wishlistCount ?? 0); ?></span>
        </a>
        <button type="button" id="nav-cart-link-mobile" onclick="window.dispatchEvent(new CustomEvent('cart-drawer-open'))" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-brand-teal hover:bg-brand-gold/10 cursor-pointer">
            <span class="material-icons text-lg">shopping_cart</span>
            <?php echo e(site_label('nav_cart')); ?>

            <span id="nav-cart-count-mobile" class="rounded-full bg-brand-teal px-2 py-0.5 text-xs text-white" style="<?php echo e((isset($cartCount) && $cartCount > 0) ? '' : 'display:none'); ?>"><?php echo e($cartCount ?? 0); ?></span>
        </button>
        <?php if(auth()->guard()->check()): ?>
            
            <div class="relative" x-data="{ userMenuOpenMobile: false }" @click.outside="userMenuOpenMobile = false">
                <button type="button"
                        @click="userMenuOpenMobile = !userMenuOpenMobile"
                        class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10">
                    <span class="flex items-center gap-2">
                        <span class="material-icons text-lg">person</span>
                        <span class="max-w-[9rem] truncate">
                            <?php echo e(\Illuminate\Support\Str::limit(auth()->user()->name, 18)); ?>

                        </span>
                    </span>
                    <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': userMenuOpenMobile }">expand_more</span>
                </button>
                <div x-show="userMenuOpenMobile" x-transition class="mt-1 space-y-0.5 pl-2">
                    <?php if(auth()->user()->is_admin): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-brand-teal hover:bg-brand-gold/10">
                            <?php echo e(__('Dashboard panel')); ?>

                        </a>
                        <a href="<?php echo e(route('admin.settings.frontend')); ?>" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-brand-teal hover:bg-brand-gold/10">
                            <?php echo e(__('Frontend settings')); ?>

                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('account')); ?>" class="block rounded-lg px-3 py-2.5 text-sm text-brand-black/90 hover:bg-brand-gold/10">
                            <?php echo e(site_label('nav_account')); ?>

                        </a>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="block w-full rounded-lg px-3 py-2.5 text-left text-sm text-brand-black/90 hover:bg-brand-gold/10">
                            <?php echo e(site_label('nav_logout')); ?>

                        </button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            
            <div class="relative" x-data="{ accountOpenMobile: false }" @click.outside="accountOpenMobile = false">
                <button type="button" @click="accountOpenMobile = !accountOpenMobile" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-brand-black/90 hover:bg-brand-gold/10" aria-label="<?php echo e(site_label('nav_login')); ?>">
                    <span class="material-icons text-lg">person</span>
                    <span class="material-icons text-lg transition-transform" :class="{ 'rotate-180': accountOpenMobile }">expand_more</span>
                </button>
                <div x-show="accountOpenMobile" x-transition class="mt-1 space-y-0.5 pl-2">
                    <a href="<?php echo e(route('login')); ?>" class="block rounded-lg px-3 py-2.5 text-sm text-brand-black/90 hover:bg-brand-gold/10"><?php echo e(site_label('nav_login')); ?></a>
                    <a href="<?php echo e(route('register')); ?>" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-brand-teal hover:bg-brand-gold/10"><?php echo e(site_label('nav_register')); ?></a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</nav>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\frontend\partials\navbar.blade.php ENDPATH**/ ?>