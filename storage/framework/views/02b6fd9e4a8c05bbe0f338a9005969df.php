<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php if(site_favicon_url()): ?>
    <link rel="icon" href="<?php echo e(site_favicon_url()); ?>">
    <?php endif; ?>
    <title><?php echo e(site_title()); ?><?php if(isset($header)): ?> – <?php echo e($header); ?><?php endif; ?></title>
    
    <link rel="stylesheet" href="<?php echo e(asset('css/core/tailwind.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/core/brand.css')); ?>">
    <?php if(app()->getLocale() === 'ar'): ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/core/rtl.css')); ?>">
    <?php endif; ?>
    
    <link rel="stylesheet" href="<?php echo e(asset('css/frontend/animations.css')); ?>">
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

    <main class="flex-1 py-12 md:py-16">
        <div class="container mx-auto px-4">
            <?php if(isset($header)): ?>
                <h1 class="mb-8 text-2xl font-bold text-slate-900 md:text-3xl"><?php echo e($header); ?></h1>
            <?php endif; ?>
            <?php echo e($slot); ?>

        </div>
    </main>

    <?php echo $__env->make('frontend.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
    <script defer src="<?php echo e(asset('js/frontend/navbar.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/frontend/hero-slider.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/frontend/newsletter.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/frontend/cookie-consent.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/frontend/cart-wishlist.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\layouts\app.blade.php ENDPATH**/ ?>