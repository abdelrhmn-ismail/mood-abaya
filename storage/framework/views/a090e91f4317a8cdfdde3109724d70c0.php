<?php $__env->startSection('title', ($post->meta_title ?: $post->title) . ' – ' . site_title()); ?>
<?php $__env->startSection('description', $post->meta_description ?: Str::limit(strip_tags($post->excerpt ?? $post->body ?? ''), 160)); ?>

<?php $__env->startSection('content'); ?>
    <section class="bg-slate-50 py-8 md:py-12">
        <div class="container mx-auto max-w-3xl px-4">
            <nav class="mb-6 flex flex-wrap items-center gap-1 text-sm text-brand-black/70" aria-label="<?php echo e(__('Breadcrumb')); ?>">
                <a href="<?php echo e(route('home')); ?>" class="transition hover:text-brand-teal"><?php echo e(site_label('nav_home')); ?></a>
                <span class="material-icons text-base text-brand-black/40">chevron_right</span>
                <a href="<?php echo e(route('blog.index')); ?>" class="transition hover:text-brand-teal"><?php echo e(__('Blog')); ?></a>
                <span class="material-icons text-base text-brand-black/40">chevron_right</span>
                <span class="font-medium text-brand-black"><?php echo e($post->title); ?></span>
            </nav>

            <article class="rounded-2xl border border-slate-200 bg-brand-white shadow-sm">
                <?php if($post->image): ?>
                    <div class="aspect-video w-full overflow-hidden rounded-t-2xl">
                        <img src="<?php echo e(get_image_url($post->image)); ?>" alt="<?php echo e($post->title); ?>" class="h-full w-full object-cover" loading="lazy">
                    </div>
                <?php endif; ?>
                <div class="p-6 md:p-8">
                    <time class="text-sm text-slate-500" datetime="<?php echo e($post->published_at?->toIso8601String()); ?>"><?php echo e($post->published_at?->format('d F Y')); ?></time>
                    <h1 class="mt-2 text-2xl font-bold text-brand-black md:text-3xl"><?php echo e($post->title); ?></h1>
                    <?php if($post->excerpt): ?>
                        <p class="mt-3 text-lg text-brand-black/80"><?php echo e($post->excerpt); ?></p>
                    <?php endif; ?>
                    <div class="mt-6 prose prose-slate max-w-none prose-headings:text-brand-black prose-a:text-brand-teal">
                        <?php echo safe_html($post->body ?? ''); ?>

                    </div>
                </div>
            </article>

            <p class="mt-6">
                <a href="<?php echo e(route('blog.index')); ?>" class="inline-flex items-center gap-1 text-brand-teal transition hover:text-brand-teal-dark">
                    <span class="material-icons">arrow_back</span>
                    <?php echo e(__('Back to Blog')); ?>

                </a>
            </p>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Blog\resources\views\frontend\show.blade.php ENDPATH**/ ?>