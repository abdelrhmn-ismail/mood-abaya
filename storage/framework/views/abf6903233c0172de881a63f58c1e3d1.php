<?php $__env->startSection('title', ($q ? __('Search results') . ': ' . $q : __('Search')) . ' – ' . site_title()); ?>
<?php $__env->startSection('description', $q ? __('Search results for') . ' ' . $q : __('Search products')); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $searchSubtitle = $q ? __('Search results for') . ' "' . e($q) . '"' : __('Find products by name');
    ?>
    <?php if (isset($component)) { $__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.hero-header','data' => ['title' => $q ? __('Search results') : __('Search'),'subtitle' => $searchSubtitle,'setting' => 'hero_search']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.hero-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($q ? __('Search results') : __('Search')),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchSubtitle),'setting' => 'hero_search']); ?>
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
        <div class="container mx-auto px-4">
            <?php if($q !== ''): ?>
                <p class="mb-6 text-brand-black/80">
                    <?php echo e($products->total() === 0 ? __('No products found for') : __(':count results for', ['count' => $products->total()])); ?> &ldquo;<strong class="text-brand-teal"><?php echo e(e($q)); ?></strong>&rdquo;
                </p>
                <div class="flex flex-col gap-8 lg:flex-row lg:items-start">
                    <?php if (isset($component)) { $__componentOriginal70280aec9ac01e8a3b4e747aff9e394a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal70280aec9ac01e8a3b4e747aff9e394a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.product-filters','data' => ['filters' => $filters,'preserveQueryKeys' => ['q']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.product-filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filters),'preserveQueryKeys' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['q'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal70280aec9ac01e8a3b4e747aff9e394a)): ?>
<?php $attributes = $__attributesOriginal70280aec9ac01e8a3b4e747aff9e394a; ?>
<?php unset($__attributesOriginal70280aec9ac01e8a3b4e747aff9e394a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal70280aec9ac01e8a3b4e747aff9e394a)): ?>
<?php $component = $__componentOriginal70280aec9ac01e8a3b4e747aff9e394a; ?>
<?php unset($__componentOriginal70280aec9ac01e8a3b4e747aff9e394a); ?>
<?php endif; ?>

                    <div class="min-w-0 flex-1">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php if (isset($component)) { $__componentOriginalcef45669083f418aab5b4fc994e59833 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcef45669083f418aab5b4fc994e59833 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcef45669083f418aab5b4fc994e59833)): ?>
<?php $attributes = $__attributesOriginalcef45669083f418aab5b4fc994e59833; ?>
<?php unset($__attributesOriginalcef45669083f418aab5b4fc994e59833); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcef45669083f418aab5b4fc994e59833)): ?>
<?php $component = $__componentOriginalcef45669083f418aab5b4fc994e59833; ?>
<?php unset($__componentOriginalcef45669083f418aab5b4fc994e59833); ?>
<?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="col-span-full py-12 text-center text-brand-black/70"><?php echo e(__('Try different keywords.')); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php if($products->hasPages()): ?>
                            <div class="mt-10 flex justify-center">
                                <?php echo e($products->links()); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <p class="py-12 text-center text-brand-black/70"><?php echo e(__('Enter a search term above to find products.')); ?></p>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Shop\resources\views\frontend\search.blade.php ENDPATH**/ ?>