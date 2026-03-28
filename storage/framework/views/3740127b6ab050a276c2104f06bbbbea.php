<?php $__env->startSection('title', __('Categories') . ' – ' . site_title()); ?>
<?php $__env->startSection('description', __('Shop by Category')); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.hero-header','data' => ['title' => __('Shop by Category'),'subtitle' => __('Browse our collections'),'setting' => 'hero_categories']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.hero-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Shop by Category')),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Browse our collections')),'setting' => 'hero_categories']); ?>
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
            <div class="mx-auto mt-6 grid max-w-5xl grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('categories.show', $category->slug)); ?>" class="group overflow-hidden rounded-2xl border border-slate-200 bg-brand-white shadow-sm transition hover:shadow-xl hover:border-brand-teal/30">
                        <?php if($category->image): ?>
                            <img src="<?php echo e(get_image_url($category->image)); ?>" alt="<?php echo e($category->name); ?>" class="h-48 w-full object-cover transition duration-300 group-hover:scale-105">
                        <?php else: ?>
                            <div class="flex h-48 w-full items-center justify-center bg-gradient-to-br from-brand-teal/10 to-brand-gold/10">
                                <span class="material-icons text-6xl text-brand-teal/50">category</span>
                            </div>
                        <?php endif; ?>
                        <div class="border-t border-slate-100 p-6 transition group-hover:bg-brand-gold/5">
                            <h2 class="text-xl font-semibold text-brand-black group-hover:text-brand-teal"><?php echo e($category->name); ?></h2>
                            <?php if($category->description): ?>
                                <p class="mt-2 line-clamp-2 text-sm text-brand-black/70"><?php echo e(strip_tags($category->description)); ?></p>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="col-span-full py-12 text-center text-brand-black/70"><?php echo e(__('No categories yet.')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/Shop\resources/views/frontend/categories.blade.php ENDPATH**/ ?>