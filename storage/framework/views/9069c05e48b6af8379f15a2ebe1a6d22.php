<?php
    $items = $items ?? [];
?>
<dl class="space-y-2">
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $label = $item['label'] ?? $item[0] ?? '';
            $value = $item['value'] ?? $item[1] ?? '';
            $raw = $item['raw'] ?? false;
        ?>
        <div>
            <dt class="text-sm font-medium text-gray-500"><?php echo e($label); ?></dt>
            <dd class="mt-0.5 text-sm text-gray-900">
                <?php if($raw): ?> <?php echo $value; ?> <?php else: ?> <?php echo e($value ?: '—'); ?> <?php endif; ?>
            </dd>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</dl>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\components\admin\detail-list.blade.php ENDPATH**/ ?>