<?php
    $label = $label ?? '';
    $value = $value ?? '0';
    $url = $url ?? null;
?>
<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="p-6">
        <h3 class="text-sm font-medium text-gray-500"><?php echo e($label); ?></h3>
        <?php if($url): ?>
            <a href="<?php echo e($url); ?>" class="mt-2 block text-3xl font-semibold text-gray-900 hover:text-indigo-600"><?php echo e($value); ?></a>
        <?php else: ?>
            <p class="mt-2 text-3xl font-semibold text-gray-900"><?php echo e($value); ?></p>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\components\admin\stat-card.blade.php ENDPATH**/ ?>