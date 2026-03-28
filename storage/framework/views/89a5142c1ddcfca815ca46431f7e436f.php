<?php $__env->startSection('title', __($page->page_name) . ' – ' . site_title()); ?>
<?php $__env->startSection('description', __($page->page_name)); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.hero-header','data' => ['title' => __($page->page_name),'subtitle' => null,'setting' => 'hero_page']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.hero-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__($page->page_name)),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'setting' => 'hero_page']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e)): ?>
<?php $attributes = $__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e; ?>
<?php unset($__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e)): ?>
<?php $component = $__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e; ?>
<?php unset($__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e); ?>
<?php endif; ?>

    <section class="bg-slate-50 py-16 md:py-20">
        <div class="container mx-auto max-w-3xl px-4">
            <div class="mt-8 prose prose-slate max-w-none prose-headings:text-brand-black prose-p:text-brand-black/80 prose-li:text-brand-black/80 prose-a:text-brand-teal">
                <?php if($content): ?>
                    <?php echo safe_html($content); ?>

                <?php else: ?>
                    <p class="text-brand-black/60"><?php echo e(__('No content yet.')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/Page\resources/views/frontend/page.blade.php ENDPATH**/ ?>