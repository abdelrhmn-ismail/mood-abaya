<?php $__env->startSection('title', __('Contact Us') . ' – ' . site_title()); ?>
<?php $__env->startSection('description', __('Contact Us')); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.hero-header','data' => ['title' => __('Contact Us'),'subtitle' => __('We would love to hear from you.'),'setting' => 'hero_contact']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.hero-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Contact Us')),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('We would love to hear from you.')),'setting' => 'hero_contact']); ?>
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

    
    <?php if(site_location() || site_email() || site_phone() || site_whatsapp_url() || site_instagram_url() || site_facebook_url() || site_twitter_url()): ?>
    <section class="border-b border-slate-200 bg-brand-white py-10 md:py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-xl font-bold text-brand-black md:text-2xl"><?php echo e(__('Get in touch')); ?></h2>
            <div class="mx-auto mt-8 flex max-w-4xl flex-wrap justify-center gap-8">
                <?php if(site_location()): ?>
                    <div class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50/50 px-6 py-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-teal/10 text-brand-teal">
                            <span class="material-icons text-xl">location_on</span>
                        </span>
                        <div>
                            <p class="text-sm font-medium text-brand-black/70"><?php echo e(__('Address')); ?></p>
                            <p class="text-brand-black"><?php echo e(site_location()); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(site_email()): ?>
                    <a href="mailto:<?php echo e(site_email()); ?>" class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50/50 px-6 py-4 transition hover:border-brand-teal/30 hover:bg-brand-gold/5">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-teal/10 text-brand-teal">
                            <span class="material-icons text-xl">email</span>
                        </span>
                        <div>
                            <p class="text-sm font-medium text-brand-black/70"><?php echo e(__('Email')); ?></p>
                            <p class="text-brand-teal"><?php echo e(site_email()); ?></p>
                        </div>
                    </a>
                <?php endif; ?>
                <?php if(site_phone()): ?>
                    <a href="tel:<?php echo e(preg_replace('/\s+/', '', site_phone())); ?>" class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50/50 px-6 py-4 transition hover:border-brand-teal/30 hover:bg-brand-gold/5">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-teal/10 text-brand-teal">
                            <span class="material-icons text-xl">phone</span>
                        </span>
                        <div>
                            <p class="text-sm font-medium text-brand-black/70"><?php echo e(__('Phone')); ?></p>
                            <p class="text-brand-teal"><?php echo e(site_phone()); ?></p>
                        </div>
                    </a>
                <?php endif; ?>
                <?php if(site_whatsapp_url() || site_instagram_url() || site_facebook_url() || site_twitter_url()): ?>
                    <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50/50 px-6 py-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-teal/10 text-brand-teal">
                            <span class="material-icons text-xl">share</span>
                        </span>
                        <div class="flex flex-wrap gap-2">
                            <?php if(site_whatsapp_url()): ?>
                                <a href="<?php echo e(site_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer" class="flex h-10 w-10 items-center justify-center rounded-full bg-green-500 text-white transition hover:scale-110" aria-label="<?php echo e(__('WhatsApp')); ?>">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.885-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                </a>
                            <?php endif; ?>
                            <?php if(site_instagram_url()): ?>
                                <a href="<?php echo e(site_instagram_url()); ?>" target="_blank" rel="noopener noreferrer" class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-purple-500 via-pink-500 to-amber-500 text-white transition hover:scale-110" aria-label="<?php echo e(__('Instagram')); ?>">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.058 1.644-.07 4.849-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            <?php endif; ?>
                            <?php if(site_facebook_url()): ?>
                                <a href="<?php echo e(site_facebook_url()); ?>" target="_blank" rel="noopener noreferrer" class="flex h-10 w-10 items-center justify-center rounded-full bg-[#1877f2] text-white transition hover:scale-110" aria-label="<?php echo e(__('Facebook')); ?>">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            <?php endif; ?>
                            <?php if(site_twitter_url()): ?>
                                <a href="<?php echo e(site_twitter_url()); ?>" target="_blank" rel="noopener noreferrer" class="flex h-10 w-10 items-center justify-center rounded-full bg-[#1da1f2] text-white transition hover:scale-110" aria-label="<?php echo e(__('Twitter')); ?>">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if(isset($faqs) && $faqs->isNotEmpty()): ?>
    <section class="border-b border-slate-200 bg-brand-white py-14 md:py-16">
        <div class="container mx-auto max-w-3xl px-4">
            <h2 class="text-center text-2xl font-bold text-brand-black md:text-3xl"><?php echo e(__('Frequently asked questions')); ?></h2>
            <p class="mx-auto mt-2 max-w-xl text-center text-brand-black/70">
                <?php echo e(__('Quick answers to common questions. Can\'t find what you need? Send us a message below.')); ?>

            </p>
            <div class="mt-10 space-y-2" x-data="{ openIndex: null }">
                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="rounded-xl border border-slate-200 bg-slate-50/50 transition hover:border-brand-teal/30">
                        <button type="button"
                                @click="openIndex = openIndex === <?php echo e($index); ?> ? null : <?php echo e($index); ?>"
                                class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left"
                                :aria-expanded="openIndex === <?php echo e($index); ?>"
                                aria-controls="faq-answer-<?php echo e($index); ?>"
                                id="faq-question-<?php echo e($index); ?>">
                            <span class="font-semibold text-brand-black"><?php echo e($faq->question); ?></span>
                            <span class="material-icons shrink-0 text-brand-teal transition-transform duration-200" :class="{ 'rotate-180': openIndex === <?php echo e($index); ?> }">expand_more</span>
                        </button>
                        <div id="faq-answer-<?php echo e($index); ?>"
                             role="region"
                             aria-labelledby="faq-question-<?php echo e($index); ?>"
                             x-show="openIndex === <?php echo e($index); ?>"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             x-cloak
                             class="border-t border-slate-200">
                            <div class="px-5 py-4 text-brand-black/80 prose prose-sm max-w-none prose-p:my-2 prose-ul:my-2">
                                <?php echo nl2br(e($faq->answer)); ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="bg-slate-50 py-16 md:py-20">
        <div class="container mx-auto max-w-2xl px-4">
            <h2 class="text-center text-xl font-bold text-brand-black md:text-2xl"><?php echo e(__('Send us a message')); ?></h2>
            <p class="mb-2 mt-2 text-center text-brand-black/80">
                <?php echo e(__('Have a question about your order or our collection? Send us a message and we will get back to you soon.')); ?>

            </p>

            <?php if(session('success')): ?>
                <div class="mt-6 rounded-xl bg-green-100 px-4 py-3 text-green-800" role="alert"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <form action="<?php echo e(route('contact.submit')); ?>" method="POST" class="mt-10 space-y-6 rounded-2xl border border-slate-200 bg-brand-white p-8 shadow-sm">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-brand-black"><?php echo e(__('Your Name')); ?></label>
                    <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required maxlength="255" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-brand-black"><?php echo e(__('Your Email')); ?></label>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label for="subject" class="mb-2 block text-sm font-medium text-brand-black"><?php echo e(__('Subject')); ?></label>
                    <input type="text" name="subject" id="subject" value="<?php echo e(old('subject')); ?>" maxlength="255" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                    <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label for="message" class="mb-2 block text-sm font-medium text-brand-black"><?php echo e(__('Message')); ?></label>
                    <textarea name="message" id="message" rows="5" required maxlength="10000" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20"><?php echo e(old('message')); ?></textarea>
                    <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-teal py-3.5 font-semibold text-white transition hover:bg-brand-teal-dark focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2 sm:w-auto sm:px-8">
                    <?php echo e(__('Send Message')); ?>

                </button>
            </form>

            <div class="mt-12 flex flex-wrap items-center justify-center gap-6 rounded-2xl border border-slate-200 bg-brand-white p-6">
                <div class="flex items-center gap-3 text-brand-black/80">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-gold/20 text-brand-teal">
                        <span class="material-icons text-xl">schedule</span>
                    </span>
                    <span class="text-sm"><?php echo e(__('We typically respond within 24 hours on business days.')); ?></span>
                </div>
                <div class="flex items-center gap-3 text-brand-black/80">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-teal/10 text-brand-teal">
                        <span class="material-icons text-xl">support_agent</span>
                    </span>
                    <span class="text-sm"><?php echo e(__('Need urgent help? Mention it in your message.')); ?></span>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/Contact\resources/views/frontend/contact.blade.php ENDPATH**/ ?>