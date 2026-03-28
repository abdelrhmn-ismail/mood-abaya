<?php $tinymceKey = \App\Models\Setting::get('tinymce_api_key', ''); ?>
<?php if($tinymceKey): ?>
<script src="https://cdn.tiny.cloud/1/<?php echo e($tinymceKey); ?>/tinymce/6/tinymce.min.js" referrerpolicy="origin" defer></script>
<?php endif; ?>
<script defer src="<?php echo e(asset('js/admin/tinymce-init.js')); ?>"></script>
<script defer src="<?php echo e(asset('js/admin/locale-tabs.js')); ?>"></script>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\components\admin\editor-scripts.blade.php ENDPATH**/ ?>