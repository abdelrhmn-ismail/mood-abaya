<?php $__env->startSection('title', __('Translations')); ?>
<?php $__env->startSection('heading', __('Translations')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.card', ['title' => __('Edit language strings (ar / en)')]); ?>
<p class="mb-6 text-sm text-gray-600"><?php echo e(__('Override values from lang files. Leave blank to use file default.')); ?></p>
<form action="<?php echo e(route('admin.translations.update')); ?>" method="POST" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
        <?php $__currentLoopData = $translations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-4 shadow-sm transition hover:border-gray-300">
                <label class="mb-3 block font-mono text-sm font-medium text-gray-600"><?php echo e($key); ?></label>
                <div class="space-y-3">
                    <div>
                        <span class="mb-1 block text-xs font-medium text-gray-500"><?php echo e(__('English')); ?></span>
                        <input type="text" name="translations[<?php echo e($key); ?>][en]" value="<?php echo e(old("translations.{$key}.en", $vals['en'])); ?>"
                               class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                    </div>
                    <div>
                        <span class="mb-1 block text-xs font-medium text-gray-500"><?php echo e(__('Arabic')); ?></span>
                        <input type="text" name="translations[<?php echo e($key); ?>][ar]" value="<?php echo e(old("translations.{$key}.ar", $vals['ar'])); ?>"
                               class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20" dir="rtl">
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php echo $__env->make('components.admin.form-actions', [
        'submitLabel' => __('Save translations'),
        'cancelUrl' => route('admin.settings.edit'),
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</form>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Settings\resources\views\admin\translations.blade.php ENDPATH**/ ?>