<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
      dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php if(site_favicon_url()): ?>
    <link rel="icon" href="<?php echo e(site_favicon_url()); ?>">
    <?php endif; ?>
    <?php
        $siteMetaTitle = \App\Models\Setting::get('meta_title', '');
        $siteMetaDesc = \App\Models\Setting::get('meta_description', '');
        $siteMetaKeywords = \App\Models\Setting::get('meta_keywords', '');
        $siteOgImage = \App\Models\Setting::get('og_image', '');
        $defaultTitle = $siteMetaTitle ?: site_title();
        $defaultDesc = $siteMetaDesc ?: __('Quality products for everyone. Shop with confidence.');
    ?>
    <title><?php echo $__env->yieldContent('title', $defaultTitle); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', $defaultDesc); ?>">
    <?php $pageKeywords = trim($__env->yieldContent('meta_keywords') ?? ''); $pageOgImage = trim($__env->yieldContent('og_image') ?? ''); ?>
    <?php if($pageKeywords || $siteMetaKeywords): ?>
        <meta name="keywords" content="<?php echo e($pageKeywords ?: $siteMetaKeywords); ?>">
    <?php endif; ?>
    <meta property="og:title" content="<?php echo $__env->yieldContent('title', $defaultTitle); ?>">
    <meta property="og:description" content="<?php echo $__env->yieldContent('description', $defaultDesc); ?>">
    <meta property="og:type" content="website">
    <?php if($pageOgImage || $siteOgImage): ?>
        <meta property="og:image" content="<?php echo e($pageOgImage ?: $siteOgImage); ?>">
    <?php endif; ?>

    
    <link rel="stylesheet" href="<?php echo e(asset('css/core/tailwind.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/core/brand.css')); ?>">
    <?php if(app()->getLocale() === 'ar'): ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/core/rtl.css')); ?>">
    <?php endif; ?>
    
    <link rel="stylesheet" href="<?php echo e(asset('css/frontend/animations.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/frontend/components.css')); ?>">

    
    <?php echo $__env->make('components.color-overrides', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <link rel="stylesheet" href="https://unpkg.com/@material-tailwind/html@latest/styles/material-tailwind.css" />

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Cinzel:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" />

    
    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js" defer></script>

    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php $headerCode = \App\Models\Setting::get('custom_code_header', ''); ?>
    <?php if(trim($headerCode) !== ''): ?>
        <?php echo $headerCode; ?>

    <?php endif; ?>
</head>
<body class="min-h-screen bg-brand-white text-brand-black antialiased <?php echo e(app()->getLocale() === 'ar' ? 'font-cairo' : 'font-cinzel'); ?>" data-ripple-light="true">
    <?php echo $__env->make('frontend.partials.announcement-bar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('frontend.partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="flex-1">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('frontend.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('frontend.partials.floating-social', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('frontend.partials.cookie-consent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('frontend.partials.home-popup', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('frontend.partials.quick-view-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('components.frontend.cart-drawer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
    
    <script defer src="<?php echo e(asset('js/frontend/navbar.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/frontend/hero-slider.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/frontend/newsletter.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/frontend/cookie-consent.js')); ?>"></script>
    <script src="<?php echo e(asset('js/frontend/cart-drawer.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/frontend/cart-wishlist.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php $footerCode = \App\Models\Setting::get('custom_code_footer', ''); ?>
    <?php if(trim($footerCode) !== ''): ?>
        <?php echo $footerCode; ?>

    <?php endif; ?>
</body>
</html>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views/frontend/layouts/app.blade.php ENDPATH**/ ?>