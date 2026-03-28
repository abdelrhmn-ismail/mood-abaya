<?php $__env->startSection('title', $category->name . ' – ' . site_title()); ?>
<?php $__env->startSection('description', Str::limit(strip_tags($category->description ?? ''), 160) ?: $category->name); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": <?php echo e(json_encode(__('Categories'))); ?>, "item": <?php echo e(json_encode(route('categories'))); ?> },
            { "@type": "ListItem", "position": 2, "name": <?php echo e(json_encode($category->name)); ?> }
        ]
    }
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <section class="bg-slate-50 py-10 md:py-14">
        <div class="container mx-auto px-4">
            <nav class="mb-6 flex flex-wrap items-center gap-1 text-sm text-brand-black/70" aria-label="<?php echo e(__('Breadcrumb')); ?>">
                <a href="<?php echo e(route('categories')); ?>" class="transition hover:text-brand-teal"><?php echo e(__('Categories')); ?></a>
                <span class="material-icons text-base text-brand-black/40">chevron_right</span>
                <span class="font-medium text-brand-black"><?php echo e($category->name); ?></span>
            </nav>
            <h1 class="text-4xl font-bold tracking-tight text-brand-black md:text-5xl"><?php echo e($category->name); ?></h1>
            <?php if($category->description): ?>
                <div class="mt-4 max-w-2xl text-brand-black/80 prose prose-slate prose-headings:text-brand-black prose-a:text-brand-teal"><?php echo safe_html($category->description); ?></div>
            <?php endif; ?>

            <div class="mt-10 flex flex-col gap-8 lg:flex-row lg:items-start">
                <?php if (isset($component)) { $__componentOriginal70280aec9ac01e8a3b4e747aff9e394a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal70280aec9ac01e8a3b4e747aff9e394a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.product-filters','data' => ['filters' => $filters]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.product-filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filters)]); ?>
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
                            <p class="col-span-full py-12 text-center text-brand-black/70"><?php echo e(__('No products in this category.')); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if($products->hasPages()): ?>
                        <div class="mt-10 flex justify-center">
                            <?php echo e($products->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/Shop\resources/views/frontend/category.blade.php ENDPATH**/ ?>