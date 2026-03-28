<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'filters' => [],
    'preserveQueryKeys' => [],
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
    'filters' => [],
    'preserveQueryKeys' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $filters = $filters ?? [];
?>
<aside class="shrink-0 rounded-xl border border-slate-200 bg-white p-4 shadow-sm lg:w-64">
    <form method="GET" action="<?php echo e(request()->url()); ?>" class="space-y-4">
        <?php $__currentLoopData = $preserveQueryKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(request($key) !== null && request($key) !== ''): ?>
                <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e(request($key)); ?>">
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div>
            <span class="text-sm font-medium text-slate-600"><?php echo e(__('Sort by')); ?></span>
            <select name="sort" class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20" onchange="this.form.submit()">
                <option value="name_asc" <?php echo e(($filters['sort'] ?? '') === 'name_asc' ? 'selected' : ''); ?>><?php echo e(__('Name A–Z')); ?></option>
                <option value="name_desc" <?php echo e(($filters['sort'] ?? '') === 'name_desc' ? 'selected' : ''); ?>><?php echo e(__('Name Z–A')); ?></option>
                <option value="price_asc" <?php echo e(($filters['sort'] ?? '') === 'price_asc' ? 'selected' : ''); ?>><?php echo e(__('Price: low to high')); ?></option>
                <option value="price_desc" <?php echo e(($filters['sort'] ?? '') === 'price_desc' ? 'selected' : ''); ?>><?php echo e(__('Price: high to low')); ?></option>
                <option value="newest" <?php echo e(($filters['sort'] ?? '') === 'newest' ? 'selected' : ''); ?>><?php echo e(__('Newest')); ?></option>
            </select>
        </div>
        <div>
            <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="in_stock" value="1" <?php echo e(($filters['in_stock'] ?? false) ? 'checked' : ''); ?> onchange="this.form.submit()" class="rounded border-slate-300 text-brand-teal focus:ring-brand-teal">
                <?php echo e(__('In stock only')); ?>

            </label>
        </div>
        <div>
            <span class="text-sm font-medium text-slate-600"><?php echo e(__('Price range')); ?></span>
            <div class="mt-1 flex items-center gap-2">
                <input type="number" name="price_min" step="0.01" min="0" placeholder="<?php echo e(__('Min')); ?>" value="<?php echo e($filters['price_min'] ?? ''); ?>" class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-sm focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                <span class="text-slate-400">–</span>
                <input type="number" name="price_max" step="0.01" min="0" placeholder="<?php echo e(__('Max')); ?>" value="<?php echo e($filters['price_max'] ?? ''); ?>" class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-sm focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
            </div>
        </div>
        <button type="submit" class="w-full rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-teal-dark"><?php echo e(__('Apply')); ?></button>
    </form>
</aside>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\components\frontend\product-filters.blade.php ENDPATH**/ ?>