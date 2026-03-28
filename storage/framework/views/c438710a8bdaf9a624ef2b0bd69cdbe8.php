<?php $__env->startSection('title', __('Edit category')); ?>
<?php $__env->startSection('heading', __('Edit category')); ?>

<?php $__env->startSection('content'); ?>
<?php $locales = config('app.available_locales', ['en', 'ar']); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
<form action="<?php echo e(route('admin.categories.update', $category)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div>
        <p class="mb-2 text-sm font-medium text-gray-700"><?php echo e(__('Translations')); ?></p>
        <div class="flex gap-2 border-b border-gray-200">
            <?php $__currentLoopData = $locales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" class="locale-tab rounded-t px-4 py-2 text-sm font-medium <?php echo e($loop->first ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-100'); ?>" data-locale="<?php echo e($locale); ?>"><?php echo e($locale === 'en' ? __('English') : __('Arabic')); ?></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php $__currentLoopData = $locales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="locale-panel mt-4 space-y-4 <?php echo e($loop->first ? '' : 'hidden'); ?>" data-locale="<?php echo e($locale); ?>">
                <?php echo $__env->make('components.admin.form-field', [
                    'name' => "name[{$locale}]",
                    'label' => __('Name') . " ({$locale})",
                    'type' => 'text',
                    'value' => old("name.{$locale}", $category->getTranslation('name', $locale, false)),
                    'required' => $loop->first,
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php echo $__env->make('components.admin.rich-editor', [
                    'name' => "description[{$locale}]",
                    'id' => 'description_' . $locale,
                    'label' => __('Description') . " ({$locale})",
                    'value' => old("description.{$locale}", $category->getTranslation('description', $locale, false)),
                    'errorKey' => "description.{$locale}",
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'slug', 'label' => __('Slug'), 'type' => 'text', 'value' => old('slug', $category->slug)], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'image', 'label' => __('Image'), 'type' => 'file', 'value' => '', 'attributes' => ['accept' => 'image/*', 'current' => $category->image, 'current_url' => $category->image ? get_image_url($category->image) : '']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'sort_order', 'label' => __('Sort order'), 'type' => 'number', 'value' => old('sort_order', $category->sort_order), 'attributes' => ['min' => 0]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'active', 'label' => '', 'type' => 'checkbox', 'value' => $category->active, 'attributes' => ['help' => __('Active')]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-actions', [
        'submitLabel' => __('Update category'),
        'cancelUrl' => route('admin.categories.index'),
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</form>
<?php echo $__env->renderComponent(); ?>
<?php $__env->startPush('admin-scripts'); ?>
<?php echo $__env->make('components.admin.editor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Shop\resources\views\admin\categories\edit.blade.php ENDPATH**/ ?>