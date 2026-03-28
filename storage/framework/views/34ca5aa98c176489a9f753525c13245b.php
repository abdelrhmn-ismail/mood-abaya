<?php
    $submitLabel = $submitLabel ?? __('Save');
    $cancelUrl = $cancelUrl ?? null;
    $cancelLabel = $cancelLabel ?? __('Cancel');
    /** @var string|null $submitForm When set, submit button uses the HTML `form` attribute (submit from outside that form). */
    $submitForm = $submitForm ?? null;
?>
<div class="flex flex-wrap items-center gap-3 pt-2">
    <button type="submit" <?php if($submitForm): ?> form="<?php echo e($submitForm); ?>" <?php endif; ?> class="rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white hover:bg-brand-teal-dark focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2">
        <?php echo e($submitLabel); ?>

    </button>
    <?php if($cancelUrl): ?>
        <a href="<?php echo e($cancelUrl); ?>" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            <?php echo e($cancelLabel); ?>

        </a>
    <?php endif; ?>
    <?php echo e($slot ?? ''); ?>

</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\components\admin\form-actions.blade.php ENDPATH**/ ?>