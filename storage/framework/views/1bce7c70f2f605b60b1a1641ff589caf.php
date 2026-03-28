<form method="GET" class="mb-6 flex flex-wrap items-center gap-2">
    <input type="hidden" name="per_page" value="<?php echo e(request('per_page', admin_per_page_default())); ?>">
    <?php if(request()->has('sort')): ?>
        <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>">
        <input type="hidden" name="order" value="<?php echo e(request('order', 'asc')); ?>">
    <?php endif; ?>
    <?php echo e($slot); ?>

    <button type="submit" class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300">
        <?php echo e(__('Filter')); ?>

    </button>
</form>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views/components/admin/filter-bar.blade.php ENDPATH**/ ?>