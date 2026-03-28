<?php $__env->startSection('title', __('Edit product')); ?>
<?php $__env->startSection('heading', __('Edit product')); ?>

<?php $__env->startSection('content'); ?>
<?php $locales = config('app.available_locales', ['en', 'ar']); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
<form id="admin-product-edit-form" action="<?php echo e(route('admin.products.update', $product)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <?php echo $__env->make('components.admin.form-field', [
        'name' => 'category_id',
        'label' => __('Category'),
        'type' => 'select',
        'value' => old('category_id', $product->category_id),
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
                    'value' => old("name.{$locale}", $product->getTranslation('name', $locale, false)),
                    'required' => $loop->first,
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php echo $__env->make('components.admin.rich-editor', [
                    'name' => "description[{$locale}]",
                    'id' => 'description_' . $locale,
                    'label' => __('Description') . " ({$locale})",
                    'value' => old("description.{$locale}", $product->getTranslation('description', $locale, false)),
                    'errorKey' => "description.{$locale}",
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'slug', 'label' => __('Slug'), 'type' => 'text', 'value' => old('slug', $product->slug)], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'sku', 'label' => __('SKU'), 'type' => 'text', 'value' => old('sku', $product->sku)], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'barcode', 'label' => __('Barcode'), 'type' => 'text', 'value' => old('barcode', $product->barcode)], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'short_description', 'label' => __('Short description'), 'type' => 'textarea', 'value' => old('short_description', $product->short_description), 'attributes' => ['rows' => 2]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'tags', 'label' => __('Tags'), 'type' => 'text', 'value' => old('tags', $product->tags), 'attributes' => ['placeholder' => __('Comma-separated')]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'meta_title', 'label' => __('Meta title'), 'type' => 'text', 'value' => old('meta_title', $product->meta_title)], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'meta_description', 'label' => __('Meta description'), 'type' => 'textarea', 'value' => old('meta_description', $product->meta_description), 'attributes' => ['rows' => 2]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'meta_keywords', 'label' => __('Meta keywords'), 'type' => 'text', 'value' => old('meta_keywords', $product->meta_keywords), 'attributes' => ['placeholder' => 'keyword1, keyword2']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'og_image', 'label' => __('OG image URL'), 'type' => 'text', 'value' => old('og_image', $product->og_image), 'attributes' => ['placeholder' => 'https://']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'price', 'label' => __('Price (SAR)'), 'type' => 'number', 'value' => old('price', $product->price), 'required' => true, 'attributes' => ['step' => '0.01', 'min' => 0]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'compare_at_price', 'label' => __('Compare at price (SAR)'), 'type' => 'number', 'value' => old('compare_at_price', $product->compare_at_price), 'attributes' => ['step' => '0.01', 'min' => 0, 'placeholder' => __('Original price for discount display')]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'image', 'label' => __('Main image'), 'type' => 'file', 'value' => '', 'attributes' => ['accept' => 'image/*', 'current' => $product->image, 'current_url' => $product->image ? get_image_url($product->image) : '']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div>
        <label class="mb-2 block text-sm font-medium text-gray-700"><?php echo e(__('Gallery images')); ?></label>
        <?php if($product->images->isNotEmpty()): ?>
            <div class="mb-3 flex flex-wrap gap-3">
                <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="relative inline-block">
                        <img src="<?php echo e(get_image_url($img->image)); ?>" alt="" class="h-24 w-24 rounded border object-cover">
                        <label class="absolute right-1 top-1 flex items-center gap-1 rounded bg-red-100 px-2 py-1 text-xs text-red-700">
                            <input type="checkbox" name="delete_image_ids[]" value="<?php echo e($img->id); ?>" class="rounded">
                            <?php echo e(__('Delete')); ?>

                        </label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
        <input type="file" name="images[]" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:rounded file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200">
        <p class="mt-1 text-xs text-gray-500"><?php echo e(__('Add more images. Check Delete to remove existing.')); ?></p>
    </div>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'stock', 'label' => __('Stock'), 'type' => 'number', 'value' => old('stock', $product->stock), 'attributes' => ['min' => 0]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'min_order_qty', 'label' => __('Min. order qty'), 'type' => 'number', 'value' => old('min_order_qty', $product->min_order_qty ?? 1), 'attributes' => ['min' => 1]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'max_order_qty', 'label' => __('Max. order qty'), 'type' => 'number', 'value' => old('max_order_qty', $product->max_order_qty), 'attributes' => ['min' => 1, 'placeholder' => __('Leave empty for no limit')]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'weight_kg', 'label' => __('Weight (kg)'), 'type' => 'number', 'value' => old('weight_kg', $product->weight_kg), 'attributes' => ['step' => '0.01', 'min' => 0]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'active', 'label' => '', 'type' => 'checkbox', 'value' => $product->active, 'attributes' => ['help' => __('Active')]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.admin.form-field', ['name' => 'featured', 'label' => '', 'type' => 'checkbox', 'value' => $product->featured, 'attributes' => ['help' => __('Featured')]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</form>

    
    
    <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-6">
        <h3 class="mb-4 text-sm font-semibold text-gray-900"><?php echo e(__('Product variants')); ?></h3>
        <p class="mb-4 text-xs text-gray-500"><?php echo e(__('Add variants with their own SKU, price and stock. Use attributes JSON e.g. {"Size":"M","Color":"Black"} for one variant.')); ?></p>
        <?php if($product->variants->isNotEmpty()): ?>
            <table class="mb-4 w-full rounded-lg border border-gray-200 bg-white text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-3 py-2 text-left font-medium text-gray-600"><?php echo e(__('SKU')); ?></th>
                        <th class="px-3 py-2 text-left font-medium text-gray-600"><?php echo e(__('Attributes')); ?></th>
                        <th class="px-3 py-2 text-left font-medium text-gray-600"><?php echo e(__('Price')); ?></th>
                        <th class="px-3 py-2 text-left font-medium text-gray-600"><?php echo e(__('Stock')); ?></th>
                        <th class="px-3 py-2 text-right font-medium text-gray-600"><?php echo e(__('Actions')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-t border-gray-100">
                            <td class="px-3 py-2 font-mono"><?php echo e($v->sku ?? '—'); ?></td>
                            <td class="px-3 py-2"><?php echo e($v->getDisplayName()); ?></td>
                            <td class="px-3 py-2"><?php echo e(number_format($v->price, 2)); ?> <?php echo e(__('SAR')); ?></td>
                            <td class="px-3 py-2"><?php echo e($v->stock); ?></td>
                            <td class="px-3 py-2 text-right">
                                <form action="<?php echo e(route('admin.products.variants.destroy', [$product, $v])); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('Remove this variant?')); ?>');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:underline"><?php echo e(__('Remove')); ?></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
        <form action="<?php echo e(route('admin.products.variants.store', $product)); ?>" method="POST" class="flex flex-wrap items-end gap-3">
            <?php echo csrf_field(); ?>
            <div class="min-w-[120px]">
                <label class="block text-xs font-medium text-gray-600"><?php echo e(__('SKU')); ?></label>
                <input type="text" name="sku" class="mt-1 block w-full rounded-lg border border-gray-300 text-sm" placeholder="<?php echo e(__('e.g. SKU-M')); ?>">
            </div>
            <div class="min-w-[100px]">
                <label class="block text-xs font-medium text-gray-600"><?php echo e(__('Price (SAR)')); ?> *</label>
                <input type="number" name="price" step="0.01" min="0" required class="mt-1 block w-full rounded-lg border border-gray-300 text-sm" value="0">
            </div>
            <div class="min-w-[80px]">
                <label class="block text-xs font-medium text-gray-600"><?php echo e(__('Stock')); ?> *</label>
                <input type="number" name="stock" min="0" required class="mt-1 block w-full rounded-lg border border-gray-300 text-sm" value="0">
            </div>
            <div class="min-w-[200px] flex-1">
                <label class="block text-xs font-medium text-gray-600"><?php echo e(__('Attributes (JSON)')); ?></label>
                <input type="text" name="attributes" class="mt-1 block w-full rounded-lg border border-gray-300 font-mono text-sm" placeholder='{"Size":"M"} or {"Color":"Black"}'>
            </div>
            <button type="submit" class="rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white hover:bg-brand-teal-dark"><?php echo e(__('Add variant')); ?></button>
        </form>
    </div>

    <?php echo $__env->make('components.admin.form-actions', [
        'submitLabel' => __('Update product'),
        'cancelUrl' => route('admin.products.index'),
        'submitForm' => 'admin-product-edit-form',
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->startPush('admin-scripts'); ?>
<?php echo $__env->make('components.admin.editor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Shop\resources\views\admin\products\edit.blade.php ENDPATH**/ ?>