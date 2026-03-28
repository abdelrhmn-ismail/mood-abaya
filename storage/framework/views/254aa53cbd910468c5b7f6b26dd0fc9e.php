<?php $__env->startSection('title', __('About Us') . ' – ' . site_title()); ?>
<?php $__env->startSection('description', __('About us') . ' – ' . site_title() . '. ' . __('Quality abayas, jilbabs and hijabs for the modern modest wardrobe.')); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.hero-header','data' => ['title' => __('About Us'),'subtitle' => __('Quality abayas, jilbabs and hijabs for the modern modest wardrobe.'),'setting' => 'hero_page']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.hero-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('About Us')),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Quality abayas, jilbabs and hijabs for the modern modest wardrobe.')),'setting' => 'hero_page']); ?>
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

    <section class="bg-slate-50 py-16 md:py-24">
        <div class="container mx-auto max-w-4xl px-4">
            <p class="mt-6 text-lg leading-relaxed text-brand-black/80">
                <?php echo e(__('We are dedicated to offering a carefully curated selection of abayas, jilbabs, and hijabs that combine modesty with contemporary style.')); ?>

            </p>

            <div class="mt-14 space-y-14">
                
                <div class="rounded-2xl border border-slate-200 bg-brand-white p-8 shadow-sm md:p-10">
                    <h2 class="text-2xl font-bold text-brand-black"><?php echo e(__('Our story')); ?></h2>
                    <p class="mt-4 leading-relaxed text-brand-black/80">
                        <?php echo e(__('From the beginning, we wanted to create a place where you can find quality modest wear without compromise. We source fabrics and designs that last, and we take care of every detail so you can shop with confidence.')); ?>

                    </p>
                    <p class="mt-4 leading-relaxed text-brand-black/80">
                        <?php echo e(__('Whether you are looking for a classic abaya, a comfortable jilbab, or a versatile hijab, our collection is updated regularly to bring you the best in modest fashion.')); ?>

                    </p>
                </div>

                
                <div>
                    <h2 class="text-2xl font-bold text-brand-black"><?php echo e(__('Our values')); ?></h2>
                    <div class="mt-8 grid gap-6 sm:grid-cols-2">
                        <div class="flex gap-4 rounded-xl border border-slate-200 bg-brand-white p-6">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-teal/10 text-brand-teal">
                                <span class="material-icons text-2xl">check_circle</span>
                            </span>
                            <div>
                                <h3 class="font-semibold text-brand-black"><?php echo e(__('Quality')); ?></h3>
                                <p class="mt-2 text-sm text-brand-black/70"><?php echo e(__('We choose durable materials and careful craftsmanship so every piece meets your expectations.')); ?></p>
                            </div>
                        </div>
                        <div class="flex gap-4 rounded-xl border border-slate-200 bg-brand-white p-6">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-gold/20 text-brand-teal">
                                <span class="material-icons text-2xl">style</span>
                            </span>
                            <div>
                                <h3 class="font-semibold text-brand-black"><?php echo e(__('Style & modesty')); ?></h3>
                                <p class="mt-2 text-sm text-brand-black/70"><?php echo e(__('We believe you can look elegant and stay true to your values. Our designs reflect that balance.')); ?></p>
                            </div>
                        </div>
                        <div class="flex gap-4 rounded-xl border border-slate-200 bg-brand-white p-6">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-teal/10 text-brand-teal">
                                <span class="material-icons text-2xl">people</span>
                            </span>
                            <div>
                                <h3 class="font-semibold text-brand-black"><?php echo e(__('Customer first')); ?></h3>
                                <p class="mt-2 text-sm text-brand-black/70"><?php echo e(__('Your satisfaction matters. We are here to help with orders, sizing, and any questions.')); ?></p>
                            </div>
                        </div>
                        <div class="flex gap-4 rounded-xl border border-slate-200 bg-brand-white p-6">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-gold/20 text-brand-teal">
                                <span class="material-icons text-2xl">local_shipping</span>
                            </span>
                            <div>
                                <h3 class="font-semibold text-brand-black"><?php echo e(__('Reliable delivery')); ?></h3>
                                <p class="mt-2 text-sm text-brand-black/70"><?php echo e(__('We ship with care and keep you updated so your order reaches you safely and on time.')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="rounded-2xl border border-slate-200 bg-brand-teal/5 p-8 md:p-10">
                    <h2 class="text-2xl font-bold text-brand-black"><?php echo e(__('Why choose us')); ?></h2>
                    <ul class="mt-6 space-y-3 text-brand-black/80">
                        <li class="flex items-start gap-3">
                            <span class="material-icons mt-0.5 text-brand-teal">done</span>
                            <span><?php echo e(__('Wide range of abayas, jilbabs, and hijabs for every occasion.')); ?></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-icons mt-0.5 text-brand-teal">done</span>
                            <span><?php echo e(__('Premium fabrics and finishes for comfort and durability.')); ?></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-icons mt-0.5 text-brand-teal">done</span>
                            <span><?php echo e(__('Secure payment and hassle-free returns.')); ?></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-icons mt-0.5 text-brand-teal">done</span>
                            <span><?php echo e(__('Friendly customer support before and after your purchase.')); ?></span>
                        </li>
                    </ul>
                </div>

                <?php echo $__env->make('frontend.partials.testimonials-block', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                
                <div class="flex flex-wrap items-center justify-center gap-4 border-t border-slate-200 pt-12">
                    <a href="<?php echo e(route('categories')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-brand-teal px-6 py-3 font-semibold text-white transition hover:bg-brand-teal-dark">
                        <?php echo e(__('Shop now')); ?>

                        <span class="material-icons">arrow_forward</span>
                    </a>
                    <a href="<?php echo e(route('contact')); ?>" class="inline-flex items-center gap-2 rounded-xl border-2 border-brand-teal px-6 py-3 font-semibold text-brand-teal transition hover:bg-brand-teal hover:text-white">
                        <?php echo e(__('Contact us')); ?>

                    </a>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Core\resources\views\frontend\about.blade.php ENDPATH**/ ?>