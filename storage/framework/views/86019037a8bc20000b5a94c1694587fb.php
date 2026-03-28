<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'products']));

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

foreach (array_filter((['title', 'products']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->class('mt-14 rounded-2xl border border-slate-200 bg-brand-white p-6 md:p-8')); ?>>
    <h2 class="text-xl font-bold text-brand-black"><?php echo e($title); ?></h2>
    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cardProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginalcef45669083f418aab5b4fc994e59833 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcef45669083f418aab5b4fc994e59833 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.product-card','data' => ['product' => $cardProduct]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cardProduct)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcef45669083f418aab5b4fc994e59833)): ?>
<?php $attributes = $__attributesOriginalcef45669083f418aab5b4fc994e59833; ?>
<?php unset($__attributesOriginalcef45669083f418aab5b4fc994e59833); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcef45669083f418aab5b4fc994e59833)): ?>
<?php $component = $__componentOriginalcef45669083f418aab5b4fc994e59833; ?>
<?php unset($__componentOriginalcef45669083f418aab5b4fc994e59833); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views/components/frontend/product-grid-section.blade.php ENDPATH**/ ?>