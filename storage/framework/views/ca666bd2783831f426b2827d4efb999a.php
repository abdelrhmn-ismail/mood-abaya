<?php $__env->startSection('title', ($product->meta_title ?: $product->name) . ' – ' . site_title()); ?>
<?php $__env->startSection('description', $product->meta_description ?: Str::limit(strip_tags($product->description ?? ''), 160)); ?>
<?php $__env->startSection('meta_keywords', $product->meta_keywords ?? ''); ?>
<?php $__env->startSection('og_image', get_image_url($product->og_image) ?? ''); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": <?php echo e(json_encode(__('Categories'))); ?>, "item": <?php echo e(json_encode(route('categories'))); ?> },
            { "@type": "ListItem", "position": 2, "name": <?php echo e(json_encode($product->category->name)); ?>, "item": <?php echo e(json_encode(route('categories.show', $product->category->slug))); ?> },
            { "@type": "ListItem", "position": 3, "name": <?php echo e(json_encode($product->name)); ?> }
        ]
    }
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <section class="bg-slate-50 py-8 md:py-12">
        <div class="container mx-auto px-4">
            
            <nav class="mb-6 flex flex-wrap items-center gap-1 text-sm text-brand-black/70" aria-label="<?php echo e(__('Breadcrumb')); ?>">
                <a href="<?php echo e(route('categories')); ?>" class="transition hover:text-brand-teal"><?php echo e(__('Categories')); ?></a>
                <span class="material-icons text-base text-brand-black/40">chevron_right</span>
                <a href="<?php echo e(route('categories.show', $product->category->slug)); ?>" class="transition hover:text-brand-teal"><?php echo e($product->category->name); ?></a>
                <span class="material-icons text-base text-brand-black/40">chevron_right</span>
                <span class="font-medium text-brand-black"><?php echo e($product->name); ?></span>
            </nav>

            <div class="mx-auto max-w-6xl">
                <div class="grid gap-10 lg:grid-cols-2 lg:gap-14">
                    
                    <?php $displayImages = $product->getDisplayImages(); ?>
                    <div class="space-y-4">
                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-brand-white shadow-sm" x-data="{ active: 0 }">
                            <?php if($displayImages->isEmpty()): ?>
                                <div class="flex aspect-square w-full items-center justify-center bg-slate-100">
                                    <span class="material-icons text-8xl text-slate-300">inventory_2</span>
                                </div>
                            <?php else: ?>
                                <div class="relative aspect-square w-full bg-slate-100">
                                    <?php $__currentLoopData = $displayImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <img src="<?php echo e(get_image_url($item->image)); ?>" alt="<?php echo e($product->name); ?>"
                                             class="absolute inset-0 h-full w-full object-cover transition-opacity duration-300 <?php echo e($index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'); ?>"
                                             :class="active === <?php echo e($index); ?> ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <?php if($displayImages->count() > 1): ?>
                                    <div class="flex flex-wrap justify-center gap-2 border-t border-slate-100 bg-slate-50/50 p-3">
                                        <?php $__currentLoopData = $displayImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <button type="button" class="h-14 w-14 shrink-0 overflow-hidden rounded-lg border-2 transition focus:ring-2 focus:ring-brand-teal focus:ring-offset-2"
                                                    :class="active === <?php echo e($index); ?> ? 'border-brand-teal ring-1 ring-brand-teal' : 'border-slate-200 hover:border-slate-300'"
                                                    @click="active = <?php echo e($index); ?>"
                                                    aria-label="<?php echo e(__('Image')); ?> <?php echo e($index + 1); ?>">
                                                <img src="<?php echo e(get_image_url($item->image)); ?>" alt="" class="h-full w-full object-cover">
                                            </button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <?php if($product->video): ?>
                            <?php
                                $vExt = strtolower(pathinfo($product->video, PATHINFO_EXTENSION));
                                $videoMime = match ($vExt) {
                                    'webm' => 'video/webm',
                                    'mov' => 'video/quicktime',
                                    default => 'video/mp4',
                                };
                            ?>
                            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-black shadow-sm">
                                <p class="border-b border-slate-800 bg-slate-900 px-4 py-2 text-sm font-medium text-white"><?php echo e(__('Product video')); ?></p>
                                <video class="aspect-video w-full object-contain" controls playsinline preload="metadata"
                                       <?php if($displayImages->isNotEmpty()): ?> poster="<?php echo e(get_image_url($displayImages->first()->image)); ?>" <?php endif; ?>>
                                    <source src="<?php echo e(public_media_url($product->video)); ?>" type="<?php echo e($videoMime); ?>">
                                    <?php echo e(__('Your browser does not support the video tag.')); ?>

                                </video>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="lg:sticky lg:top-24 lg:self-start">
                        <?php if($product->hasDiscount()): ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-800">
                                <span class="material-icons text-lg">local_offer</span> <?php echo e(__('Save')); ?> <?php echo e($product->discountPercent()); ?>%
                            </span>
                        <?php endif; ?>
                        <h1 class="mt-3 text-3xl font-bold tracking-tight text-brand-black md:text-4xl"><?php echo e($product->name); ?></h1>

                        
                        <?php $hasVariants = $product->hasVariants(); $variants = $product->variants; ?>
                        <div class="mt-4 flex flex-wrap items-center gap-4">
                            <div class="flex items-baseline gap-2">
                                <p class="text-2xl font-bold text-brand-teal" id="product-price"><?php echo e(number_format($product->price, 2)); ?> <?php echo e(__('SAR')); ?></p>
                                <?php if(!$hasVariants && $product->hasDiscount()): ?>
                                    <p class="text-lg text-slate-500 line-through"><?php echo e(number_format($product->compare_at_price, 2)); ?> <?php echo e(__('SAR')); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php if($product->visibleReviewsCount() > 0): ?>
                                <div class="flex items-center gap-1.5 rounded-lg bg-brand-gold/10 px-3 py-1.5">
                                    <?php for($s = 1; $s <= 5; $s++): ?>
                                        <span class="material-icons text-lg <?php echo e($s <= round($product->averageRating()) ? 'text-amber-500' : 'text-slate-300'); ?>">star</span>
                                    <?php endfor; ?>
                                    <span class="ml-1 text-sm font-medium text-brand-black">(<?php echo e($product->visibleReviewsCount()); ?> <?php echo e($product->visibleReviewsCount() === 1 ? __('review') : __('reviews')); ?>)</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        
                        <?php if(!$hasVariants): ?>
                        <div class="mt-5 flex items-center gap-2 rounded-xl border border-slate-200 bg-brand-white px-4 py-3">
                            <?php if($product->stock > 0): ?>
                                <span class="material-icons text-brand-teal">check_circle</span>
                                <span class="text-sm font-medium text-brand-black"><?php echo e(__('In stock')); ?>: <?php echo e($product->stock); ?></span>
                            <?php else: ?>
                                <span class="material-icons text-amber-600">cancel</span>
                                <span class="text-sm font-medium text-amber-600"><?php echo e(__('Out of stock')); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <?php if($product->description): ?>
                            <div class="mt-6 text-brand-black/80 prose prose-slate max-w-none prose-headings:text-brand-black prose-a:text-brand-teal">
                                <?php echo safe_html(Str::limit(strip_tags($product->description), 200)); ?>

                                <?php if(strlen(strip_tags($product->description)) > 200): ?>
                                    <span class="text-brand-teal">…</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        
                        <?php if($hasVariants): ?>
                        <div class="mt-5 space-y-4" x-data="{ variantId: '', variant: null, price: '<?php echo e(number_format($product->price, 2)); ?>', stock: 0, variants: <?php echo e($variants->map(fn($v) => ['id' => $v->id, 'price' => $v->price, 'stock' => $v->stock, 'name' => $v->getDisplayName()])->values()->toJson()); ?> }">
                            <div>
                                <label for="product-variant" class="block text-sm font-medium text-brand-black"><?php echo e(__('Variant')); ?></label>
                                <select id="product-variant" name="product_variant_id" class="mt-1 block w-full max-w-xs rounded-xl border border-slate-300 bg-white px-3 py-2 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20"
                                        x-model="variantId"
                                        @change="variant = $event.target.value ? variants.find(i => i.id == parseInt($event.target.value)) : null; if(variant) { price = Number(variant.price).toFixed(2); stock = variant.stock; document.getElementById('product-price').textContent = price + ' <?php echo e(__('SAR')); ?>'; document.getElementById('variant-stock').textContent = variant.stock > 0 ? '<?php echo e(__('In stock')); ?>: ' + variant.stock : '<?php echo e(__('Out of stock')); ?>'; document.getElementById('variant-stock').previousElementSibling.className = 'material-icons ' + (variant.stock > 0 ? 'text-brand-teal' : 'text-amber-600'); } else { document.getElementById('variant-stock').textContent = '<?php echo e(__('Select a variant')); ?>'; document.getElementById('variant-stock').previousElementSibling.className = 'material-icons text-slate-400'; }">
                                    <option value=""><?php echo e(__('Select option')); ?></option>
                                    <?php $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($v->id); ?>" data-stock="<?php echo e($v->stock); ?>"><?php echo e($v->getDisplayName()); ?> — <?php echo e(number_format($v->price, 2)); ?> <?php echo e(__('SAR')); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-brand-white px-4 py-3" id="variant-stock-wrap">
                                <span class="material-icons text-slate-400">inventory_2</span>
                                <span class="text-sm text-slate-500" id="variant-stock"><?php echo e(__('Select a variant')); ?></span>
                            </div>
                            <form action="<?php echo e(route('cart.store')); ?>" method="POST" class="inline" data-ajax-cart>
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                <input type="hidden" name="product_variant_id" :value="variantId">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-teal px-8 py-4 font-semibold text-white shadow-lg transition hover:bg-brand-teal-dark disabled:opacity-50 disabled:pointer-events-none" :disabled="!variantId || (variant && variant.stock < 1)" data-added-label="<?php echo e(__('In cart')); ?>">
                                    <span class="material-icons">shopping_cart</span>
                                    <span class="cart-btn-text"><?php echo e(__('Add to Cart')); ?></span>
                                </button>
                            </form>
                        </div>
                        <?php endif; ?>

                        
                        <?php if(!$hasVariants): ?>
                        <?php
                            $inCartNoVariant = app(\Modules\Cart\Services\CartService::class)->hasInCart($product->id, null);
                        ?>
                        <div class="mt-8 flex flex-wrap items-center gap-3">
                            <form action="<?php echo e(route('cart.store')); ?>" method="POST" class="inline" data-ajax-cart data-in-cart="<?php echo e($inCartNoVariant ? '1' : '0'); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-teal px-8 py-4 font-semibold text-white shadow-lg transition hover:bg-brand-teal-dark disabled:opacity-50 disabled:pointer-events-none" <?php if($product->stock < 1 || $inCartNoVariant): ?> disabled <?php endif; ?> data-added-label="<?php echo e(__('In cart')); ?>">
                                    <span class="material-icons">shopping_cart</span>
                                    <span class="cart-btn-text"><?php echo e($inCartNoVariant ? __('In cart') : __('Add to Cart')); ?></span>
                                </button>
                            </form>
                            <div class="inline-flex">
                                <?php echo $__env->make('frontend.partials.wishlist-button', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        
                        <div class="mt-8 flex flex-wrap gap-6 border-t border-slate-200 pt-6 text-sm text-brand-black/70">
                            <span class="flex items-center gap-2"><span class="material-icons text-brand-teal text-xl">local_shipping</span> <?php echo e(__('Shipping')); ?></span>
                            <span class="flex items-center gap-2"><span class="material-icons text-brand-teal text-xl">assignment_return</span> <?php echo e(__('Returns')); ?></span>
                            <span class="flex items-center gap-2"><span class="material-icons text-brand-teal text-xl">verified_user</span> <?php echo e(__('Secure payment')); ?></span>
                        </div>
                    </div>
                </div>

                
                <?php if($product->description && strlen(strip_tags($product->description)) > 200): ?>
                    <div class="mt-14 rounded-2xl border border-slate-200 bg-brand-white p-6 md:p-8">
                        <h2 class="text-xl font-bold text-brand-black"><?php echo e(__('Description')); ?></h2>
                        <div class="mt-4 text-brand-black/80 prose prose-slate max-w-none prose-headings:text-brand-black prose-a:text-brand-teal">
                            <?php echo safe_html($product->description); ?>

                        </div>
                    </div>
                <?php elseif($product->description): ?>
                    <div class="mt-14 rounded-2xl border border-slate-200 bg-brand-white p-6 md:p-8">
                        <h2 class="text-xl font-bold text-brand-black"><?php echo e(__('Description')); ?></h2>
                        <div class="mt-4 text-brand-black/80 prose prose-slate max-w-none">
                            <?php echo safe_html($product->description); ?>

                        </div>
                    </div>
                <?php endif; ?>

                
                <?php if($product->reviews->isNotEmpty()): ?>
                    <?php
                        $ratingCounts = $product->reviews->groupBy('rating')->map->count();
                        $maxCount = $ratingCounts->max() ?: 1;
                    ?>
                    <div class="mt-14 rounded-2xl border border-slate-200 bg-brand-white p-6 md:p-8">
                        <h2 class="text-xl font-bold text-brand-black"><?php echo e(__('Reviews')); ?> (<?php echo e($product->reviews->count()); ?>)</h2>
                        
                        <div class="mt-4 flex flex-wrap items-center gap-6 rounded-xl bg-slate-50/80 p-4">
                            <?php for($stars = 5; $stars >= 1; $stars--): ?>
                                <?php $count = $ratingCounts->get($stars, 0); ?>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-slate-600"><?php echo e($stars); ?> <?php echo e(__('stars')); ?></span>
                                    <div class="h-2 w-24 overflow-hidden rounded-full bg-slate-200">
                                        <div class="h-full rounded-full bg-amber-500" style="width: <?php echo e(($count / $maxCount) * 100); ?>%"></div>
                                    </div>
                                    <span class="text-sm text-slate-500"><?php echo e($count); ?></span>
                                </div>
                            <?php endfor; ?>
                        </div>
                        <ul class="mt-6 space-y-5">
                            <?php $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex gap-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4 transition hover:border-brand-teal/20">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-gold/20 text-brand-teal">
                                        <span class="material-icons">person</span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center justify-between gap-2">
                                            <div class="flex items-center gap-2">
                                                <?php for($s = 1; $s <= 5; $s++): ?>
                                                    <span class="material-icons text-lg <?php echo e($s <= $review->rating ? 'text-amber-500' : 'text-slate-300'); ?>"><?php echo e($s <= $review->rating ? 'star' : 'star_border'); ?></span>
                                                <?php endfor; ?>
                                                <span class="text-sm font-semibold text-brand-black"><?php echo e($review->user->name ?? __('Customer')); ?></span>
                                                <?php if($review->isVerifiedPurchase()): ?>
                                                    <span class="inline-flex items-center gap-0.5 rounded bg-green-100 px-1.5 py-0.5 text-xs font-medium text-green-800" title="<?php echo e(__('Verified purchase')); ?>">
                                                        <span class="material-icons text-sm">verified</span> <?php echo e(__('Verified purchase')); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <span class="text-xs text-brand-black/50"><?php echo e($review->created_at->format('d M Y')); ?></span>
                                        </div>
                                        <?php if($review->comment): ?>
                                            <p class="mt-2 text-sm text-brand-black/80"><?php echo e($review->comment); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                
                <?php if(isset($relatedProducts) && $relatedProducts->isNotEmpty()): ?>
                    <?php if (isset($component)) { $__componentOriginal29e5560e62e32c654494c3368361940f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal29e5560e62e32c654494c3368361940f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.product-grid-section','data' => ['title' => __('You may also like'),'products' => $relatedProducts]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.product-grid-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('You may also like')),'products' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($relatedProducts)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal29e5560e62e32c654494c3368361940f)): ?>
<?php $attributes = $__attributesOriginal29e5560e62e32c654494c3368361940f; ?>
<?php unset($__attributesOriginal29e5560e62e32c654494c3368361940f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal29e5560e62e32c654494c3368361940f)): ?>
<?php $component = $__componentOriginal29e5560e62e32c654494c3368361940f; ?>
<?php unset($__componentOriginal29e5560e62e32c654494c3368361940f); ?>
<?php endif; ?>
                <?php endif; ?>

                
                <?php if(isset($recentlyViewed) && $recentlyViewed->isNotEmpty()): ?>
                    <?php if (isset($component)) { $__componentOriginal29e5560e62e32c654494c3368361940f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal29e5560e62e32c654494c3368361940f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.product-grid-section','data' => ['title' => __('Recently viewed'),'products' => $recentlyViewed]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.product-grid-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Recently viewed')),'products' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recentlyViewed)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal29e5560e62e32c654494c3368361940f)): ?>
<?php $attributes = $__attributesOriginal29e5560e62e32c654494c3368361940f; ?>
<?php unset($__attributesOriginal29e5560e62e32c654494c3368361940f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal29e5560e62e32c654494c3368361940f)): ?>
<?php $component = $__componentOriginal29e5560e62e32c654494c3368361940f; ?>
<?php unset($__componentOriginal29e5560e62e32c654494c3368361940f); ?>
<?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Shop\resources\views\frontend\product.blade.php ENDPATH**/ ?>