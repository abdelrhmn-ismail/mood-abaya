<?php $__env->startSection('title', __('Edit') . ': ' . $page->page_name); ?>
<?php $__env->startSection('heading', __('Edit') . ': ' . $page->page_name); ?>

<?php $__env->startSection('content'); ?>
<?php $locales = config('app.available_locales', ['en', 'ar']); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
<form action="<?php echo e(route('admin.page-contents.update', $page)); ?>" method="POST" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <p class="text-sm text-gray-600"><?php echo e($page->page_name); ?> — <?php echo e(__('Edit content in English and Arabic.')); ?></p>
    <div>
        <p class="mb-2 text-sm font-medium text-gray-700"><?php echo e(__('Translations')); ?></p>
        <div class="flex gap-2 border-b border-gray-200">
            <?php $__currentLoopData = $locales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" class="locale-tab rounded-t px-4 py-2 text-sm font-medium <?php echo e($loop->first ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-100'); ?>" data-locale="<?php echo e($locale); ?>"><?php echo e($locale === 'en' ? __('English') : __('Arabic')); ?></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php $__currentLoopData = $locales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $contentKey = 'page_content_' . $locale;
                $value = old($contentKey, $page->$contentKey ?? '');
            ?>
            <div class="locale-panel mt-4 <?php echo e($loop->first ? '' : 'hidden'); ?>" data-locale="<?php echo e($locale); ?>">
                <?php echo $__env->make('components.admin.rich-editor', [
                    'name' => $contentKey,
                    'id' => 'page_content_' . $locale,
                    'label' => __('Content') . ' (' . ($locale === 'en' ? __('English') : __('Arabic')) . ')',
                    'value' => $value,
                    'errorKey' => $contentKey,
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php echo $__env->make('components.admin.form-actions', [
        'submitLabel' => __('Save'),
        'cancelUrl' => route('admin.page-contents.index'),
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</form>
<?php echo $__env->renderComponent(); ?>
<?php $__env->startPush('admin-scripts'); ?>
<?php echo $__env->make('components.admin.editor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Page\resources\views\admin\edit.blade.php ENDPATH**/ ?>