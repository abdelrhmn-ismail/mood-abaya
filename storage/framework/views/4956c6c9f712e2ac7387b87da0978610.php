<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php if(site_favicon_url()): ?>
    <link rel="icon" href="<?php echo e(site_favicon_url()); ?>">
    <?php endif; ?>
    <title><?php echo e(site_title()); ?></title>
    
    <link rel="stylesheet" href="<?php echo e(asset('css/core/tailwind.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/core/brand.css')); ?>">
    <?php if(app()->getLocale() === 'ar'): ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/core/rtl.css')); ?>">
    <?php endif; ?>
    
    <link rel="stylesheet" href="<?php echo e(asset('css/frontend/components.css')); ?>">
    <?php echo $__env->make('components.color-overrides', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Cinzel:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/@material-tailwind/html@latest/styles/material-tailwind.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js" defer></script>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased <?php echo e(app()->getLocale() === 'ar' ? 'font-cairo' : 'font-cinzel'); ?>" data-ripple-light="true">
    <?php echo $__env->make('frontend.partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="min-h-[60vh] py-16 md:py-20">
        <div class="container mx-auto max-w-md px-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                <?php echo e($slot); ?>

            </div>
        </div>
    </main>

    <?php echo $__env->make('frontend.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
    <script defer src="<?php echo e(asset('js/frontend/navbar.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/frontend/cookie-consent.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/frontend/cart-wishlist.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views/layouts/guest.blade.php ENDPATH**/ ?>