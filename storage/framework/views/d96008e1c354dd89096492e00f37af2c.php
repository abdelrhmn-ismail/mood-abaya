<?php
    $url = $url ?? url()->previous();
    $text = $text ?? __('Back');
?>
<p class="mt-6">
    <a href="<?php echo e($url); ?>" class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 hover:text-indigo-900">
        <span class="material-icons text-lg">arrow_back</span>
        <?php echo e($text); ?>

    </a>
</p>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\components\admin\back-link.blade.php ENDPATH**/ ?>