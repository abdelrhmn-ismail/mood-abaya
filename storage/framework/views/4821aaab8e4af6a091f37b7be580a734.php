<?php $__env->startSection('title', __('Blog') . ' – ' . site_title()); ?>
<?php $__env->startSection('description', __('News and updates from') . ' ' . site_title()); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.hero-header','data' => ['title' => __('Blog'),'subtitle' => __('News and announcements'),'setting' => 'hero_page']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.hero-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Blog')),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('News and announcements')),'setting' => 'hero_page']); ?>
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

    <section class="bg-slate-50 py-12 md:py-16">
        <div class="container mx-auto px-4">
            <?php if($posts->isEmpty()): ?>
                <p class="text-center text-brand-black/70"><?php echo e(__('No posts yet.')); ?></p>
            <?php else: ?>
                <div class="mx-auto grid max-w-6xl gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-brand-white shadow-sm transition hover:shadow-lg">
                            <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="block aspect-video w-full overflow-hidden bg-slate-100">
                                <?php if($post->image): ?>
                                    <img src="<?php echo e(get_image_url($post->image)); ?>" alt="<?php echo e($post->title); ?>" class="h-full w-full object-cover transition duration-300 hover:scale-105" loading="lazy">
                                <?php else: ?>
                                    <span class="flex h-full w-full items-center justify-center text-slate-300">
                                        <span class="material-icons text-6xl">article</span>
                                    </span>
                                <?php endif; ?>
                            </a>
                            <div class="flex flex-1 flex-col p-5">
                                <time class="text-sm text-slate-500" datetime="<?php echo e($post->published_at?->toIso8601String()); ?>"><?php echo e($post->published_at?->format('d M Y')); ?></time>
                                <h2 class="mt-2 font-semibold text-brand-black line-clamp-2">
                                    <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="transition hover:text-brand-teal"><?php echo e($post->title); ?></a>
                                </h2>
                                <?php if($post->excerpt): ?>
                                    <p class="mt-2 flex-1 text-sm text-brand-black/70 line-clamp-3"><?php echo e($post->excerpt); ?></p>
                                <?php endif; ?>
                                <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-brand-teal transition hover:text-brand-teal-dark">
                                    <?php echo e(__('Read more')); ?>

                                    <span class="material-icons text-lg">arrow_forward</span>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($posts->hasPages()): ?>
                    <div class="mt-10 flex justify-center"><?php echo e($posts->links()); ?></div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Blog\resources\views\frontend\index.blade.php ENDPATH**/ ?>