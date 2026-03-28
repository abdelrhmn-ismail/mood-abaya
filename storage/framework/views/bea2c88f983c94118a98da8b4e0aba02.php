<?php $__env->startSection('title', __('Add product')); ?>
<?php $__env->startSection('heading', __('Add product')); ?>

<?php $__env->startSection('content'); ?>
<?php $locales = config('app.available_locales', ['en', 'ar']); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
<form action="<?php echo e(route('admin.products.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php echo $__env->make('components.admin.form-field', [
        'name' => 'category_id',
        'label' => __('Category'),
        'type' => 'select',
        'value' => old('category_id'),
        'required' => true,
        'options' => collect($categories)->map(fn($c) => ['value' => $c->id, 'label' => $c->name])->values()->all(),
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                    'value' => old("name.{$locale}", ''),
                    'required' => $loop->first,
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php echo $__env->make('components.admin.rich-editor', [
                    'name' => "description[{$locale}]",
                    'id' => 'description_' . $locale,
                    'label' => __('Description') . " ({$locale})",
                    'value' => old("description.{$locale}", ''),
                    'errorKey' => "description.{$locale}",
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'slug', 'label' => __('Slug'), 'type' => 'text', 'value' => old('slug', '')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'sku', 'label' => __('SKU'), 'type' => 'text', 'value' => old('sku', '')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'barcode', 'label' => __('Barcode'), 'type' => 'text', 'value' => old('barcode', '')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'short_description', 'label' => __('Short description'), 'type' => 'textarea', 'value' => old('short_description', ''), 'attributes' => ['rows' => 2]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'tags', 'label' => __('Tags'), 'type' => 'text', 'value' => old('tags', ''), 'attributes' => ['placeholder' => __('Comma-separated')]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'meta_title', 'label' => __('Meta title'), 'type' => 'text', 'value' => old('meta_title', '')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'meta_description', 'label' => __('Meta description'), 'type' => 'textarea', 'value' => old('meta_description', ''), 'attributes' => ['rows' => 2]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'meta_keywords', 'label' => __('Meta keywords'), 'type' => 'text', 'value' => old('meta_keywords', ''), 'attributes' => ['placeholder' => 'keyword1, keyword2']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'og_image', 'label' => __('OG image URL'), 'type' => 'text', 'value' => old('og_image', ''), 'attributes' => ['placeholder' => 'https://']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'price', 'label' => __('Price (SAR)'), 'type' => 'number', 'value' => old('price', ''), 'required' => true, 'attributes' => ['step' => '0.01', 'min' => 0]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'compare_at_price', 'label' => __('Compare at price (SAR)'), 'type' => 'number', 'value' => old('compare_at_price', ''), 'attributes' => ['step' => '0.01', 'min' => 0, 'placeholder' => __('Original price for discount display')]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'image', 'label' => __('Main image'), 'type' => 'file', 'value' => '', 'attributes' => ['accept' => 'image/*']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div>
        <label class="mb-2 block text-sm font-medium text-gray-700"><?php echo e(__('Gallery images')); ?></label>
        <input type="file" name="images[]" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:rounded file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200">
        <p class="mt-1 text-xs text-gray-500"><?php echo e(__('Optional. Add multiple product images.')); ?></p>
    </div>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'stock', 'label' => __('Stock'), 'type' => 'number', 'value' => old('stock', 0), 'attributes' => ['min' => 0]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'min_order_qty', 'label' => __('Min. order qty'), 'type' => 'number', 'value' => old('min_order_qty', 1), 'attributes' => ['min' => 1]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'max_order_qty', 'label' => __('Max. order qty'), 'type' => 'number', 'value' => old('max_order_qty', ''), 'attributes' => ['min' => 1, 'placeholder' => __('Leave empty for no limit')]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'weight_kg', 'label' => __('Weight (kg)'), 'type' => 'number', 'value' => old('weight_kg', ''), 'attributes' => ['step' => '0.01', 'min' => 0]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'active', 'label' => '', 'type' => 'checkbox', 'value' => true, 'attributes' => ['help' => __('Active')]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'featured', 'label' => '', 'type' => 'checkbox', 'value' => false, 'attributes' => ['help' => __('Featured')]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-actions', [
        'submitLabel' => __('Create product'),
        'cancelUrl' => route('admin.products.index'),
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</form>
<?php echo $__env->renderComponent(); ?>
<?php $__env->startPush('admin-scripts'); ?>
<?php echo $__env->make('components.admin.editor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Shop\resources\views\admin\products\create.blade.php ENDPATH**/ ?>