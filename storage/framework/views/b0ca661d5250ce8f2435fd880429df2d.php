<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'show' => true,
    'label' => null,
    'fixed' => false,
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
    'show' => true,
    'label' => null,
    'fixed' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if($show): ?>
<div
    <?php echo e($attributes->merge([
        'class' => ($fixed ? 'fixed' : 'absolute') . ' inset-0 z-[100] flex items-center justify-center bg-white/70',
        'role' => 'status',
        'aria-label' => $label ?? __('Loading'),
    ])); ?>

>
    <div class="flex flex-col items-center gap-3">
        <span
            class="inline-block h-8 w-8 animate-spin rounded-full border-2 border-slate-300 border-t-brand-teal"
            aria-hidden="true"
        ></span>
        <?php if($label): ?>
            <span class="text-sm font-medium text-slate-600"><?php echo e($label); ?></span>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\components\loader.blade.php ENDPATH**/ ?>