<?php
    $title = $title ?? null;
    $class = $class ?? '';
?>
<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm <?php echo e($class); ?>">
    <?php if($title): ?>
        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
            <h2 class="text-lg font-semibold text-gray-900"><?php echo e($title); ?></h2>
        </div>
    <?php endif; ?>
    <div class="p-6">
        <?php echo e($slot); ?>

    </div>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views/components/admin/card.blade.php ENDPATH**/ ?>