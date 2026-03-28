<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'subtitle' => null,
    /**
     * Name of the Setting key that stores the image URL/path.
     * Example: 'hero_account', 'hero_categories', 'hero_products'.
     */
    'setting' => null,
]));

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

foreach (array_filter(([
    'title',
    'subtitle' => null,
    /**
     * Name of the Setting key that stores the image URL/path.
     * Example: 'hero_account', 'hero_categories', 'hero_products'.
     */
    'setting' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $image = null;
    if ($setting) {
        $val = \App\Models\Setting::get($setting, '');
        if ($val) {
            $image = get_image_url($val) ?? $val;
        }
    }
?>

<section class="relative overflow-hidden bg-brand-teal" aria-labelledby="hero-header-title">
    <div class="absolute inset-0">
        <?php if($image): ?>
            <img src="<?php echo e($image); ?>" alt="" class="h-full w-full object-cover opacity-80">
        <?php else: ?>
            <div class="h-full w-full bg-gradient-to-r from-brand-teal via-brand-teal-dark to-brand-teal opacity-90"></div>
        <?php endif; ?>
    </div>
    <div class="absolute inset-0 bg-brand-teal/55"></div>
    <div class="relative">
        <div class="container mx-auto px-4 py-12 text-center text-white md:py-16">
            <h1 id="hero-header-title" class="text-3xl font-bold tracking-tight md:text-4xl lg:text-5xl">
                <?php echo e($title); ?>

            </h1>
            <?php if($subtitle): ?>
                <p class="mt-3 max-w-2xl mx-auto text-sm text-white/90 md:text-base">
                    <?php echo e($subtitle); ?>

                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\components\frontend\hero-header.blade.php ENDPATH**/ ?>