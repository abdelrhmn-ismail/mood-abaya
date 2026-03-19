<?php $__env->startSection('title', config('app.name') . ' – ' . __('Shop the Best')); ?>
<?php $__env->startSection('description', __('Quality products for everyone. Shop with confidence.')); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $heroRaw = fn ($key, $default) => \App\Models\Setting::get($key, $default);
        $heroUrl = function ($val) {
            if (empty($val)) return $val;
            return str_starts_with($val, 'http') ? $val : \Illuminate\Support\Facades\Storage::url($val);
        };
        $hero1 = $heroUrl($heroRaw('hero_home_1', 'https://images.unsplash.com/photo-1558171813-4c088753af8f?w=1920'));
        $hero2 = $heroUrl($heroRaw('hero_home_2', 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1920'));
        $hero3 = $heroUrl($heroRaw('hero_home_3', 'https://images.unsplash.com/photo-1583391733982-1cfec2046952?w=1920'));
    ?>

    
    <section class="relative h-[70vh] min-h-[420px] overflow-hidden bg-brand-teal" data-hero-slider>
        <div class="absolute inset-0">
            <div class="absolute inset-0 transition-opacity duration-700 opacity-100" data-hero-slide style="background: url('<?php echo e($hero1); ?>') center/cover no-repeat;"></div>
            <div class="absolute inset-0 transition-opacity duration-700 opacity-0 pointer-events-none" data-hero-slide style="background: url('<?php echo e($hero2); ?>') center/cover no-repeat;"></div>
            <div class="absolute inset-0 transition-opacity duration-700 opacity-0 pointer-events-none" data-hero-slide style="background: url('<?php echo e($hero3); ?>') center/cover no-repeat;"></div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-brand-black/70 via-brand-teal/40 to-transparent"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center text-white">
            <h1 class="text-4xl font-bold tracking-tight drop-shadow-lg md:text-5xl lg:text-6xl"><?php echo e(__('Welcome to :name', ['name' => config('app.name')])); ?></h1>
            <p class="mt-4 max-w-xl text-lg text-white/95 md:text-xl"><?php echo e(__('Quality products for everyone. Shop with confidence.')); ?></p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="<?php echo e(route('categories')); ?>" class="rounded-xl bg-brand-white px-8 py-3.5 text-sm font-semibold text-brand-teal shadow-lg transition hover:bg-brand-gold hover:text-brand-black">
                    <?php echo e(__('Shop Now')); ?>

                </a>
                <a href="<?php echo e(route('categories')); ?>#categories" class="rounded-xl border-2 border-white/90 bg-white/10 px-8 py-3.5 text-sm font-semibold text-white backdrop-blur transition hover:bg-brand-gold/30 hover:border-brand-gold">
                    <?php echo e(__('View Categories')); ?>

                </a>
            </div>
        </div>
        <div class="absolute bottom-6 left-1/2 flex -translate-x-1/2 gap-2" aria-hidden="true">
            <button type="button" class="h-2.5 w-2.5 rounded-full bg-white/90 transition hover:bg-white" data-hero-dot aria-current="true"></button>
            <button type="button" class="h-2.5 w-2.5 rounded-full bg-white/40 transition hover:bg-white" data-hero-dot aria-current="false"></button>
            <button type="button" class="h-2.5 w-2.5 rounded-full bg-white/40 transition hover:bg-white" data-hero-dot aria-current="false"></button>
        </div>
    </section>

    
    <section id="about" class="border-b border-slate-200 bg-brand-white py-16 md:py-20">
        <div class="container mx-auto px-4">
            <div class="mx-auto max-w-4xl text-center">
                <h2 class="text-3xl font-bold text-brand-black md:text-4xl"><?php echo e(__('About Us')); ?></h2>
                <p class="mt-4 text-lg leading-relaxed text-brand-black/80">
                    <?php echo e(__('We offer a curated selection of abayas, jilbabs, and hijabs for the modern modest wardrobe. Quality fabrics, timeless designs, and a seamless shopping experience.')); ?>

                </p>
                <a href="<?php echo e(route('about')); ?>" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-teal px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-teal-dark">
                    <?php echo e(__('Learn more about us')); ?>

                    <span class="material-icons text-lg">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    <?php echo $__env->make('frontend.partials.testimonials-block', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <section class="border-b border-slate-200 bg-brand-white py-4">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-center gap-8 md:gap-12">
                <div class="flex items-center gap-3 text-brand-black/80">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-gold/20 text-brand-teal"><span class="material-icons text-xl">local_shipping</span></span>
                    <span class="text-sm font-medium"><?php echo e(__('Shipping')); ?></span>
                </div>
                <div class="flex items-center gap-3 text-brand-black/80">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-gold/20 text-brand-teal"><span class="material-icons text-xl">verified_user</span></span>
                    <span class="text-sm font-medium"><?php echo e(__('Secure payment')); ?></span>
                </div>
                <div class="flex items-center gap-3 text-brand-black/80">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-gold/20 text-brand-teal"><span class="material-icons text-xl">assignment_return</span></span>
                    <span class="text-sm font-medium"><?php echo e(__('Easy returns')); ?></span>
                </div>
                <div class="flex items-center gap-3 text-brand-black/80">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-gold/20 text-brand-teal"><span class="material-icons text-xl">support_agent</span></span>
                    <span class="text-sm font-medium"><?php echo e(__('Support')); ?></span>
                </div>
            </div>
        </div>
    </section>

    
    <section class="relative overflow-hidden bg-brand-teal py-16 md:py-20">
        <div class="absolute inset-0 bg-gradient-to-br from-brand-teal-dark/50 to-brand-teal/80"></div>
        <div class="container relative mx-auto px-4 text-center text-white">
            <h2 class="text-3xl font-bold md:text-4xl"><?php echo e(__('Discover our collection')); ?></h2>
            <p class="mx-auto mt-3 max-w-2xl text-white/90">
                <?php echo e(__('Shop abayas, jilbabs, and hijabs crafted with care. New styles added regularly.')); ?>

            </p>
            <a href="<?php echo e(route('categories')); ?>" class="mt-8 inline-flex items-center gap-2 rounded-xl bg-brand-gold px-8 py-3.5 font-semibold text-brand-black transition hover:bg-brand-gold-dark">
                <?php echo e(__('Browse all categories')); ?>

                <span class="material-icons">storefront</span>
            </a>
        </div>
    </section>

    
    <section id="categories" class="bg-slate-50 py-20 md:py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-3xl font-bold text-brand-black md:text-4xl"><?php echo e(__('Shop by Category')); ?></h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-brand-black/70"><?php echo e(__('Browse our collections')); ?></p>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('categories.show', $category->slug)); ?>" class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-brand-white shadow-sm transition hover:shadow-xl hover:border-brand-teal/30">
                        <?php if($category->image): ?>
                            <img src="<?php echo e(asset('storage/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>" class="h-48 w-full object-cover transition duration-300 group-hover:scale-105">
                        <?php else: ?>
                            <div class="flex h-48 w-full items-center justify-center bg-gradient-to-br from-brand-teal/10 to-brand-gold/10">
                                <span class="material-icons text-6xl text-brand-teal/50">category</span>
                            </div>
                        <?php endif; ?>
                        <div class="border-t border-slate-100 bg-brand-white p-5 transition group-hover:bg-brand-gold/5">
                            <h3 class="font-semibold text-brand-black"><?php echo e($category->name); ?></h3>
                            <p class="mt-1 text-sm text-brand-black/60"><?php echo e($category->products_count); ?> <?php echo e(__('Products')); ?></p>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="col-span-full text-center text-brand-black/70"><?php echo e(__('No categories yet.')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php if(isset($featuredProducts) && $featuredProducts->isNotEmpty()): ?>
    
    <section class="bg-brand-white py-20 md:py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-3xl font-bold text-brand-black md:text-4xl"><?php echo e(__('Featured Products')); ?></h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-brand-black/70"><?php echo e(__('Handpicked for you')); ?></p>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="mt-12 text-center">
                <a href="<?php echo e(route('categories')); ?>" class="inline-flex items-center gap-2 rounded-xl border-2 border-brand-teal px-6 py-3 text-sm font-semibold text-brand-teal transition hover:bg-brand-teal hover:text-white">
                    <?php echo e(__('View All Products')); ?>

                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <section id="products" class="bg-slate-50 py-20 md:py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-3xl font-bold text-brand-black md:text-4xl"><?php echo e(isset($featuredProducts) && $featuredProducts->isNotEmpty() ? __('New arrivals') : __('Featured Products')); ?></h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-brand-black/70"><?php echo e(isset($featuredProducts) && $featuredProducts->isNotEmpty() ? __('Just landed') : __('Handpicked for you')); ?></p>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
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
                    <p class="col-span-full text-center text-brand-black/70"><?php echo e(__('No products yet.')); ?></p>
                <?php endif; ?>
            </div>
            <?php if(isset($products) && $products->isNotEmpty()): ?>
                <div class="mt-12 text-center">
                    <a href="<?php echo e(route('categories')); ?>" class="inline-flex items-center gap-2 rounded-xl border-2 border-brand-teal px-6 py-3 text-sm font-semibold text-brand-teal transition hover:bg-brand-teal hover:text-white">
                        <?php echo e(__('View All Products')); ?>

                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    
    <section class="border-y border-slate-200 bg-slate-50 py-12 md:py-14">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 md:gap-12">
                <div class="text-center">
                    <p class="text-3xl font-bold text-brand-teal md:text-4xl"><?php echo e(__('Quality first')); ?></p>
                    <p class="mt-1 text-sm font-medium text-brand-black/70"><?php echo e(__('Every piece we sell')); ?></p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-brand-teal md:text-4xl"><?php echo e(__('Fast shipping')); ?></p>
                    <p class="mt-1 text-sm font-medium text-brand-black/70"><?php echo e(__('Across the region')); ?></p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-brand-teal md:text-4xl"><?php echo e(__('Easy returns')); ?></p>
                    <p class="mt-1 text-sm font-medium text-brand-black/70"><?php echo e(__('Hassle-free policy')); ?></p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-brand-teal md:text-4xl"><?php echo e(__('Support')); ?></p>
                    <p class="mt-1 text-sm font-medium text-brand-black/70"><?php echo e(__('We are here for you')); ?></p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="bg-brand-white py-16 md:py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-brand-black md:text-3xl"><?php echo e(__('Stay in the loop')); ?></h2>
            <p class="mx-auto mt-3 max-w-xl text-brand-black/70">
                <?php echo e(__('Subscribe for new arrivals, exclusive offers, and styling tips.')); ?>

            </p>
        </div>
    </section>

    
    <section class="bg-brand-teal py-20 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold md:text-3xl"><?php echo e(__('Get 10% off your first order')); ?></h2>
            <p class="mx-auto mt-3 max-w-lg text-white/80"><?php echo e(__('Subscribe to our newsletter')); ?></p>
            <form action="<?php echo e(route('newsletter.store')); ?>" method="POST" class="mx-auto mt-8 flex max-w-md flex-col gap-3 sm:flex-row sm:gap-2" data-newsletter="form">
                <?php echo csrf_field(); ?>
                <input type="email" name="email" placeholder="<?php echo e(__('Enter your email')); ?>" required class="flex-1 rounded-xl border border-white/30 bg-white/10 px-4 py-3 text-white placeholder-white/60 focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/40" aria-label="<?php echo e(__('Enter your email')); ?>">
                <button type="submit" class="rounded-xl bg-brand-gold px-6 py-3 font-semibold text-brand-black transition hover:bg-brand-gold-dark" data-ripple-light="true">
                    <?php echo e(__('Subscribe')); ?>

                </button>
            </form>
            <p class="mx-auto mt-3 min-h-[1.5rem] text-sm text-white/90" data-newsletter="message" aria-live="polite"></p>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/Core\resources/views/frontend/home.blade.php ENDPATH**/ ?>