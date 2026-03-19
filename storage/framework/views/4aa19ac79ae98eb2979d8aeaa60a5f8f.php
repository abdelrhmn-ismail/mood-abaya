<?php $testimonials = \App\Models\Testimonial::visible()->limit(6)->get(); ?>
<?php if($testimonials->isNotEmpty()): ?>
<section class="border-b border-slate-200 bg-slate-50 py-14 md:py-18">
    <div class="container mx-auto px-4">
        <h2 class="text-center text-2xl font-bold text-brand-black md:text-3xl"><?php echo e(__('What our customers say')); ?></h2>
        <div class="mx-auto mt-10 grid max-w-5xl gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <blockquote class="flex flex-col rounded-2xl border border-slate-200 bg-brand-white p-6 shadow-sm">
                    <span class="material-icons text-4xl text-brand-teal/40">format_quote</span>
                    <p class="mt-2 flex-1 text-brand-black/80">&ldquo;<?php echo e($t->quote); ?>&rdquo;</p>
                    <footer class="mt-4 flex items-center gap-3">
                        <?php if($t->photo): ?>
                            <img src="<?php echo e(asset('storage/' . $t->photo)); ?>" alt="" class="h-12 w-12 rounded-full object-cover">
                        <?php else: ?>
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-teal/10 text-brand-teal">
                                <span class="material-icons">person</span>
                            </span>
                        <?php endif; ?>
                        <cite class="font-semibold not-italic text-brand-black"><?php echo e($t->name); ?></cite>
                    </footer>
                </blockquote>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views/frontend/partials/testimonials-block.blade.php ENDPATH**/ ?>