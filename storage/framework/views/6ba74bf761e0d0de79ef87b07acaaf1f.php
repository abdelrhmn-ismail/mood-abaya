<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
      dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php if(site_favicon_url()): ?>
    <link rel="icon" href="<?php echo e(site_favicon_url()); ?>">
    <?php endif; ?>
    <title><?php echo $__env->yieldContent('title', __('Admin')); ?> - <?php echo e(site_title()); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Cinzel:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/core/tailwind.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/core/brand.css')); ?>">
    <?php if(app()->getLocale() === 'ar'): ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/core/rtl.css')); ?>">
    <?php endif; ?>
    
    <link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
    
    <?php echo $__env->make('components.color-overrides', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="min-h-screen bg-slate-100 text-brand-black antialiased <?php echo e(app()->getLocale() === 'ar' ? 'font-cairo' : 'font-cinzel'); ?>">
    <div class="flex min-h-screen">
        
        <div id="sidebar-overlay" class="fixed inset-0 z-20 hidden bg-black/50 md:hidden" aria-hidden="true"></div>
        
        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-30 w-64 max-w-[85vw] -translate-x-full transform bg-brand-teal text-white shadow-xl transition-transform duration-200 ease-in-out md:relative md:max-w-none md:translate-x-0 md:flex-shrink-0">
            <div class="flex h-14 items-center justify-center border-b border-brand-teal-dark px-3 sm:h-16 sm:px-4">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="truncate text-center text-base font-semibold sm:text-lg md:text-xl"><?php echo e(site_title()); ?> Admin</a>
            </div>
            <nav class="max-h-[calc(100vh-3.5rem)] space-y-1 overflow-y-auto overscroll-contain p-3 sm:max-h-[calc(100vh-4rem)] sm:p-4 md:max-h-none">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">dashboard</span> <?php echo e(__('Dashboard')); ?>

                </a>
                <a href="<?php echo e(route('admin.settings.edit')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.settings.edit') || request()->routeIs('admin.settings.update') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">settings</span> <?php echo e(__('Settings')); ?>

                </a>
                <a href="<?php echo e(route('admin.settings.frontend')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.settings.frontend*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">palette</span> <?php echo e(__('Frontend settings')); ?>

                </a>
                <a href="<?php echo e(route('admin.translations.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.translations.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">translate</span> <?php echo e(__('Translations')); ?>

                </a>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.orders.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">receipt_long</span> <?php echo e(__('Orders')); ?>

                </a>
                <a href="<?php echo e(route('admin.payments.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.payments.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">payment</span> <?php echo e(__('Payments')); ?>

                </a>
                <a href="<?php echo e(route('admin.payment-methods.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.payment-methods.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">account_balance</span> <?php echo e(__('Payment methods')); ?>

                </a>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.products.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">inventory_2</span> <?php echo e(__('Products')); ?>

                </a>
                <a href="<?php echo e(route('admin.categories.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.categories.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">category</span> <?php echo e(__('Categories')); ?>

                </a>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.users.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">people</span> <?php echo e(__('Users')); ?>

                </a>
                <a href="<?php echo e(route('admin.contacts.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.contacts.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">mail</span> <?php echo e(__('Contact messages')); ?>

                </a>
                <a href="<?php echo e(route('admin.newsletter.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.newsletter.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">subscriptions</span> <?php echo e(__('Newsletter subscribers')); ?>

                </a>
                <a href="<?php echo e(route('admin.faqs.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.faqs.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">help_outline</span> <?php echo e(__('FAQ')); ?>

                </a>
                <a href="<?php echo e(route('admin.posts.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.posts.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">newspaper</span> <?php echo e(__('Blog / News')); ?>

                </a>
                <a href="<?php echo e(route('admin.testimonials.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.testimonials.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">format_quote</span> <?php echo e(__('Testimonials')); ?>

                </a>
                <a href="<?php echo e(route('admin.page-contents.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.page-contents.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">article</span> <?php echo e(__('Page content')); ?>

                </a>
                <a href="<?php echo e(route('admin.reviews.index')); ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?php echo e(request()->routeIs('admin.reviews.*') ? 'bg-brand-teal-dark' : 'hover:bg-brand-gold/20'); ?>">
                    <span class="material-icons text-lg">star</span> <?php echo e(__('Reviews')); ?>

                </a>
            </nav>
        </aside>
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex min-h-14 flex-shrink-0 flex-wrap items-center justify-between gap-2 border-b border-slate-200 bg-brand-white px-3 py-2 sm:min-h-16 sm:gap-3 sm:px-4 md:flex-nowrap md:px-6 md:py-0">
                <div class="flex min-w-0 flex-1 items-center gap-2 sm:gap-3 md:min-w-0 md:flex-none">
                    <button type="button" id="sidebar-toggle" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg p-0 text-brand-teal hover:bg-brand-gold/10 md:hidden" aria-expanded="false" aria-controls="admin-sidebar" aria-label="<?php echo e(__('Open menu')); ?>" data-label-open="<?php echo e(__('Open menu')); ?>" data-label-close="<?php echo e(__('Close menu')); ?>">
                        <span class="material-icons text-2xl leading-none select-none" data-sidebar-toggle-icon aria-hidden="true">menu</span>
                    </button>
                    <?php if(!$__env->hasSection('heading') || trim((string) $__env->yieldContent('heading')) !== ''): ?>
                        <h1 class="min-w-0 truncate text-base font-semibold text-brand-black sm:text-lg"><?php echo $__env->yieldContent('heading', __('Admin')); ?></h1>
                    <?php endif; ?>
                </div>
                <div class="flex w-full flex-wrap items-center justify-end gap-2 sm:w-auto sm:gap-3">
                    <a href="<?php echo e(url('/')); ?>" title="<?php echo e(__('View store')); ?>" class="inline-flex items-center gap-1 rounded-xl border border-slate-200 bg-slate-50 px-2 py-1.5 text-xs font-medium text-brand-black transition hover:bg-brand-gold/10 hover:text-brand-teal sm:gap-1.5 sm:px-3 sm:py-2 sm:text-sm" target="_blank" rel="noopener noreferrer">
                        <span class="material-icons text-base sm:text-lg">storefront</span>
                        <span class="hidden sm:inline"><?php echo e(__('View store')); ?></span>
                    </a>
                    <div class="relative">
                        <label for="admin-locale" class="sr-only"><?php echo e(__('Language')); ?></label>
                        <select id="admin-locale" class="appearance-none rounded-xl border border-slate-200 bg-slate-50 py-1.5 text-xs font-medium text-brand-black focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20 sm:py-2 sm:text-sm <?php echo e(app()->getLocale() === 'ar' ? 'pl-7 pr-2 sm:pl-8 sm:pr-3' : 'pl-2 pr-7 sm:pl-3 sm:pr-8'); ?>" onchange="window.location.href='<?php echo e(url('/locale')); ?>/'+this.value">
                            <option value="en" <?php echo e(app()->getLocale() === 'en' ? 'selected' : ''); ?>><?php echo e(__('English')); ?></option>
                            <option value="ar" <?php echo e(app()->getLocale() === 'ar' ? 'selected' : ''); ?>><?php echo e(__('Arabic')); ?></option>
                        </select>
                        <span class="pointer-events-none absolute top-1/2 -translate-y-1/2 text-slate-400 <?php echo e(app()->getLocale() === 'ar' ? 'left-1.5 sm:left-2' : 'right-1.5 sm:right-2'); ?>">
                            <span class="material-icons text-base sm:text-lg">arrow_drop_down</span>
                        </span>
                    </div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="rounded-xl border border-slate-200 bg-slate-50 px-2 py-1.5 text-xs font-medium text-brand-black transition hover:bg-brand-gold/10 hover:text-brand-teal sm:px-3 sm:py-2 sm:text-sm"><?php echo e(__('Logout')); ?></button>
                    </form>
                </div>
            </header>
            <main class="min-w-0 flex-1 overflow-auto p-3 sm:p-4 md:p-6">
                <?php if(session('success')): ?>
                    <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800" role="alert"><?php echo e(__(session('success'))); ?></div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-800" role="alert"><?php echo e(__(session('error'))); ?></div>
                <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
    
    <script defer src="<?php echo e(asset('js/admin/sidebar.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/admin/delete-confirm.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php echo $__env->yieldPushContent('admin-scripts'); ?>
</body>
</html>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>