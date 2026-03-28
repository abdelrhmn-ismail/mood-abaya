<?php
    $actionUrl = $actionUrl ?? null;
    $actionLabel = $actionLabel ?? __('Add');
    $actionIcon = $actionIcon ?? 'add';
?>
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div><?php echo e($slot ?? ''); ?></div>
    <?php if($actionUrl): ?>
        <a href="<?php echo e($actionUrl); ?>" class="inline-flex items-center gap-2 rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white hover:bg-brand-teal-dark">
            <span class="material-icons text-lg"><?php echo e($actionIcon); ?></span>
            <?php echo e($actionLabel); ?>

        </a>
    <?php endif; ?>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views/components/admin/page-header.blade.php ENDPATH**/ ?>