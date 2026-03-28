<?php
    $post = $post ?? null;
    $locales = config('app.available_locales', ['en', 'ar']);
?>
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
                'name' => "title[{$locale}]",
                'label' => __('Title') . " ({$locale})",
                'type' => 'text',
                'value' => old("title.{$locale}", $post?->getTranslation('title', $locale, false)),
                'required' => $loop->first,
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('components.admin.form-field', [
                'name' => "excerpt[{$locale}]",
                'label' => __('Excerpt') . " ({$locale})",
                'type' => 'textarea',
                'value' => old("excerpt.{$locale}", $post?->getTranslation('excerpt', $locale, false)),
                'attributes' => ['rows' => 2],
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('components.admin.rich-editor', [
                'name' => "body[{$locale}]",
                'id' => 'post_body_' . $locale,
                'label' => __('Body') . " ({$locale})",
                'value' => old("body.{$locale}", $post?->getTranslation('body', $locale, false)),
                'errorKey' => "body.{$locale}",
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('components.admin.form-field', [
                'name' => "meta_title[{$locale}]",
                'label' => __('Meta title') . " ({$locale})",
                'type' => 'text',
                'value' => old("meta_title.{$locale}", $post?->getTranslation('meta_title', $locale, false)),
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('components.admin.form-field', [
                'name' => "meta_description[{$locale}]",
                'label' => __('Meta description') . " ({$locale})",
                'type' => 'textarea',
                'value' => old("meta_description.{$locale}", $post?->getTranslation('meta_description', $locale, false)),
                'attributes' => ['rows' => 2],
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'slug',
    'label' => __('Slug'),
    'type' => 'text',
    'value' => old('slug', $post?->slug),
    'attributes' => ['placeholder' => __('Leave blank to auto-generate from title (EN)')],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'image',
    'label' => __('Featured image'),
    'type' => 'file',
    'value' => '',
    'attributes' => [
        'accept' => 'image/*',
        'current' => $post?->image,
        'current_url' => $post?->image ? get_image_url($post->image) : '',
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.admin.form-field', [
    'name' => 'published_at',
    'label' => __('Published at'),
    'type' => 'datetime-local',
    'value' => old('published_at', $post?->published_at?->format('Y-m-d\TH:i')),
    'attributes' => ['placeholder' => __('Leave empty for draft')],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Blog\resources\views\admin\form.blade.php ENDPATH**/ ?>