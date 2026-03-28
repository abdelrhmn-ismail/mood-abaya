<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(__('Maintenance')); ?> – <?php echo e(site_title()); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/core/tailwind.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/core/brand.css')); ?>">
    <?php echo $__env->make('components.color-overrides', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/frontend/maintenance.css')); ?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
</head>
<body class="bg-slate-100 text-slate-800 antialiased">
    <div class="mx-auto max-w-lg px-6 py-16 text-center">
        <span class="material-icons text-7xl text-brand-teal">build</span>
        <h1 class="mt-6 text-2xl font-bold text-slate-900 md:text-3xl"><?php echo e(__('We\'ll be back soon')); ?></h1>
        <p class="mt-4 text-slate-600">
            <?php echo e(__('We are performing scheduled maintenance. Thank you for your patience.')); ?>

        </p>
        <?php if(!empty($coming_back_at)): ?>
            <p class="mt-4 rounded-xl bg-brand-teal/10 px-4 py-3 font-medium text-brand-teal">
                <?php echo e(__('Coming back at')); ?> <?php echo e($coming_back_at); ?>

            </p>
        <?php endif; ?>
        <p class="mt-8 text-sm text-slate-500"><?php echo e(site_title()); ?></p>
    </div>
</body>
</html>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Core\resources\views\frontend\maintenance.blade.php ENDPATH**/ ?>