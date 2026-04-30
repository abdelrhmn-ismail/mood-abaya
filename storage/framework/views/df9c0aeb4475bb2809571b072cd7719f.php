<?php $__env->startSection('title', __('Checkout') . ' – ' . site_title()); ?>
<?php $__env->startSection('description', __('Checkout')); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8ad7746b177a2ef6de9fad5fcb9459e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.hero-header','data' => ['title' => __('Checkout'),'subtitle' => __('Complete your order'),'setting' => 'hero_checkout']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.hero-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Checkout')),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Complete your order')),'setting' => 'hero_checkout']); ?>
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
        <div class="container mx-auto max-w-6xl px-4">
            <?php if(session('error')): ?>
                <div class="mt-6 rounded-xl bg-red-100 px-4 py-3 text-red-800"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <?php
                $initialBillingUse = old('billing_use', ($billingAddresses ?? collect())->isNotEmpty() ? 'saved' : 'new');
            ?>
            <form id="checkout-form" action="<?php echo e(route('checkout.store')); ?>" method="POST" enctype="multipart/form-data" class="mt-10 grid gap-10 lg:grid-cols-[1.4fr_1fr]" data-initial-billing-use="<?php echo e($initialBillingUse); ?>">
                <?php echo csrf_field(); ?>

                <div class="space-y-6">
                    
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm" x-data="{ billingUse: '<?php echo e(old('billing_use', ($billingAddresses ?? collect())->isNotEmpty() ? 'saved' : 'new')); ?>' }">
                        <div class="space-y-4">
                            <?php if(isset($billingAddresses) && $billingAddresses->isNotEmpty()): ?>
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex cursor-pointer items-center gap-2">
                                        <input type="radio" name="billing_use" value="saved" x-model="billingUse" class="text-brand-black">
                                        <span class="text-sm font-medium text-slate-700"><?php echo e(__('Use a saved address')); ?></span>
                                    </label>
                                    <label class="flex cursor-pointer items-center gap-2">
                                        <input type="radio" name="billing_use" value="new" x-model="billingUse" class="text-brand-black">
                                        <span class="text-sm font-medium text-slate-700"><?php echo e(__('Add new address')); ?></span>
                                    </label>
                                </div>
                                <div x-show="billingUse === 'saved'" x-cloak class="mt-3">
                                    <label for="billing_address_id" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Choose address')); ?> *</label>
                                    <select name="billing_address_id" id="billing_address_id" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                        <option value=""><?php echo e(__('Select…')); ?></option>
                                        <?php $__currentLoopData = $billingAddresses ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($addr->id); ?>" <?php echo e(old('billing_address_id', $addr->is_default ? $addr->id : null) == $addr->id ? 'selected' : ''); ?>>
                                                <?php echo e($addr->label ? $addr->label . ' – ' : ''); ?><?php echo e($addr->full_name); ?>, <?php echo e($addr->city); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['billing_address_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            <?php else: ?>
                                <input type="hidden" name="billing_use" value="new">
                            <?php endif; ?>
                            <div id="checkout-billing-new-fields" x-show="billingUse === 'new'" x-cloak class="space-y-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                                <p class="text-sm font-medium text-slate-700"><?php echo e(__('Enter billing details')); ?></p>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="billing_full_name" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Full name')); ?> *</label>
                                        <input type="text" name="billing_full_name" id="billing_full_name" value="<?php echo e(old('billing_full_name', auth()->user()?->name)); ?>" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                        <?php $__errorArgs = ['billing_full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div>
                                    <?php if (isset($component)) { $__componentOriginal7f129feca299ac4c0aa6a1d3bbb99a8a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f129feca299ac4c0aa6a1d3bbb99a8a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.phone-input','data' => ['name' => 'billing_phone','id' => 'billing_phone','value' => old('billing_phone', auth()->user()?->phone),'required' => false,'label' => __('Phone')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('phone-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'billing_phone','id' => 'billing_phone','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('billing_phone', auth()->user()?->phone)),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Phone'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7f129feca299ac4c0aa6a1d3bbb99a8a)): ?>
<?php $attributes = $__attributesOriginal7f129feca299ac4c0aa6a1d3bbb99a8a; ?>
<?php unset($__attributesOriginal7f129feca299ac4c0aa6a1d3bbb99a8a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7f129feca299ac4c0aa6a1d3bbb99a8a)): ?>
<?php $component = $__componentOriginal7f129feca299ac4c0aa6a1d3bbb99a8a; ?>
<?php unset($__componentOriginal7f129feca299ac4c0aa6a1d3bbb99a8a); ?>
<?php endif; ?>
                                </div>
                                <div>
                                    <label for="billing_address_line_1" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Address line 1')); ?> *</label>
                                    <input type="text" name="billing_address_line_1" id="billing_address_line_1" value="<?php echo e(old('billing_address_line_1')); ?>" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                    <?php $__errorArgs = ['billing_address_line_1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="billing_address_line_2" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Address line 2')); ?> (<?php echo e(__('optional')); ?>)</label>
                                    <input type="text" name="billing_address_line_2" id="billing_address_line_2" value="<?php echo e(old('billing_address_line_2')); ?>" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="billing_city" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('City')); ?> *</label>
                                        <input type="text" name="billing_city" id="billing_city" value="<?php echo e(old('billing_city')); ?>" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                        <?php $__errorArgs = ['billing_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div>
                                        <label for="billing_state" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('State / Region')); ?></label>
                                        <input type="text" name="billing_state" id="billing_state" value="<?php echo e(old('billing_state')); ?>" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                    </div>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="billing_postal_code" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Postal code')); ?></label>
                                        <input type="text" name="billing_postal_code" id="billing_postal_code" value="<?php echo e(old('billing_postal_code')); ?>" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                    </div>
                                    <div>
                                        <?php if (isset($component)) { $__componentOriginalb9a1c3d341f3d27f8e92afff6865416a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb9a1c3d341f3d27f8e92afff6865416a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.country-select','data' => ['name' => 'billing_country','id' => 'billing_country','value' => old('billing_country', 'Saudi Arabia'),'label' => __('Country')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('country-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'billing_country','id' => 'billing_country','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('billing_country', 'Saudi Arabia')),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Country'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb9a1c3d341f3d27f8e92afff6865416a)): ?>
<?php $attributes = $__attributesOriginalb9a1c3d341f3d27f8e92afff6865416a; ?>
<?php unset($__attributesOriginalb9a1c3d341f3d27f8e92afff6865416a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb9a1c3d341f3d27f8e92afff6865416a)): ?>
<?php $component = $__componentOriginalb9a1c3d341f3d27f8e92afff6865416a; ?>
<?php unset($__componentOriginalb9a1c3d341f3d27f8e92afff6865416a); ?>
<?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="notes" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Order notes')); ?></label>
                                <textarea name="notes" id="notes" rows="2" placeholder="<?php echo e(__('Optional instructions for delivery…')); ?>" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20"><?php echo e(old('notes')); ?></textarea>
                                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative lg:contents">
                    <div class="sticky top-24 z-10 self-start rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-semibold text-brand-black"><?php echo e(__('Payment Method')); ?></h2>
                        <?php
                            $firstCode = ($paymentMethods ?? collect())->first()?->code ?? 'cash';
                            $selectedPm = old('payment_method', $firstCode);
                        ?>
                        <div class="mt-3 space-y-3">
                            <?php $__empty_1 = true; $__currentLoopData = $paymentMethods ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <label class="payment-method-option flex cursor-pointer items-start gap-3 rounded-xl border border-slate-300 bg-white p-4 transition has-[:checked]:border-slate-900 has-[:checked]:ring-2 has-[:checked]:ring-slate-900/20">
                                    <input type="radio" name="payment_method" value="<?php echo e($pm->code); ?>" id="pay_<?php echo e($pm->code); ?>"
                                        class="payment-method-radio mt-1 text-brand-black"
                                        data-requires-proof="<?php echo e($pm->requires_proof ? '1' : '0'); ?>"
                                        <?php echo e($selectedPm === $pm->code ? 'checked' : ''); ?>>
                                    <span class="font-medium text-brand-black">
                                        <?php echo e($pm->nameForLocale()); ?>

                                        <?php if($pm->descriptionForLocale()): ?>
                                            <span class="mt-1 block text-sm font-normal text-slate-600"><?php echo e($pm->descriptionForLocale()); ?></span>
                                        <?php endif; ?>
                                    </span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-sm text-red-600"><?php echo e(__('No payment methods available.')); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php $__currentLoopData = $paymentMethods ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($pm->instructionsForLocale()): ?>
                                <div id="payment-instr-<?php echo e($pm->code); ?>" class="payment-method-instructions mt-3 hidden rounded-xl border border-brand-teal/30 bg-brand-teal/5 p-4 text-left text-sm text-slate-700">
                                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-brand-teal"><?php echo e(__('Payment details')); ?></p>
                                    <div class="whitespace-pre-wrap text-slate-800"><?php echo nl2br(e($pm->instructionsForLocale())); ?></div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div id="payment-proof-wrap" class="mt-3 hidden">
                            <label for="proof" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Upload payment receipt (image or PDF)')); ?> *</label>
                            <input type="file" name="proof" id="proof" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-slate-800">
                            <?php $__errorArgs = ['proof'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <h2 class="mt-6 text-xl font-semibold text-brand-black"><?php echo e(__('Order Summary')); ?></h2>
                        <ul class="mt-4 space-y-3 border-b border-slate-200 pb-4">
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex justify-between text-sm">
                                    <span class="text-slate-600"><?php echo e($item->product->name); ?> × <?php echo e($item->quantity); ?></span>
                                    <span class="font-medium text-brand-black"><?php echo e(number_format($item->product->price * $item->quantity, 2)); ?> <?php echo e(__('SAR')); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <p class="mt-3 flex justify-between text-sm text-slate-600">
                            <span><?php echo e(__('Subtotal')); ?></span>
                            <span id="checkout-subtotal"><?php echo e(number_format($subtotal, 2)); ?> <?php echo e(__('SAR')); ?></span>
                        </p>
                        <?php if($shippingType === 'zones' && count($shippingZones) > 0): ?>
                            <div class="mt-2">
                                <label for="shipping_zone_id" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Delivery area')); ?></label>
                                <select name="shipping_zone_id" id="shipping_zone_id" class="block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20" data-zones='<?php echo json_encode($shippingZones, 15, 512) ?>' data-subtotal="<?php echo e($subtotal); ?>">
                                    <?php $__currentLoopData = $shippingZones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($z['id']); ?>" data-amount="<?php echo e($z['amount']); ?>" <?php echo e($loop->first ? 'selected' : ''); ?>><?php echo e($z['label']); ?> — <?php echo e(number_format($z['amount'], 2)); ?> <?php echo e(__('SAR')); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <?php if($shippingType === 'free_over' && $shippingFreeOver && $subtotal < $shippingFreeOver): ?>
                                <p class="mt-1 text-xs text-brand-teal"><?php echo e(__('Free shipping on orders over')); ?> <?php echo e(number_format($shippingFreeOver, 0)); ?> <?php echo e(__('SAR')); ?></p>
                            <?php endif; ?>
                            <input type="hidden" name="shipping_zone_id" value="">
                        <?php endif; ?>
                        <p class="mt-2 flex justify-between text-sm text-slate-600">
                            <span><?php echo e(__('Shipping')); ?><?php if($shippingLabel && $shippingLabel !== __('Shipping')): ?> (<?php echo e($shippingLabel); ?>)<?php endif; ?></span>
                            <span id="checkout-shipping"><?php if($shippingAmount > 0): ?><?php echo e(number_format($shippingAmount, 2)); ?> <?php echo e(__('SAR')); ?><?php else: ?><?php echo e(__('Free')); ?><?php endif; ?></span>
                        </p>
                        <p class="mt-4 flex justify-between items-baseline gap-2 text-lg font-bold text-brand-black">
                            <span><?php echo e(__('Total')); ?>:</span>
                            <span class="flex items-baseline gap-1.5"><span id="checkout-total"><?php echo e(number_format($total, 2)); ?></span><span class="font-semibold text-slate-600"><?php echo e(__('SAR')); ?></span></span>
                        </p>
                        <?php $checkoutBadges = array_filter(trust_badges()); ?>
                        <?php if(!empty($checkoutBadges)): ?>
                            <div class="mt-4 flex flex-wrap items-center justify-center gap-4 border-t border-slate-100 pt-4 text-xs text-slate-500">
                                <?php $__currentLoopData = $checkoutBadges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="flex items-center gap-1"><span class="material-icons text-base text-brand-teal">verified</span> <?php echo e($badge); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                        <button type="submit" class="mt-6 w-full rounded-xl bg-brand-teal py-3.5 font-semibold text-white hover:bg-brand-teal-dark">
                            <?php echo e(__('Place Order')); ?>

                        </button>
                    </div>
                </div>
            </form>
            <script>
            (function(){
                var form = document.getElementById('checkout-form');
                var section = document.getElementById('checkout-billing-new-fields');
                if (form && section && form.getAttribute('data-initial-billing-use') === 'saved') {
                    section.querySelectorAll('[required]').forEach(function(el){ el.removeAttribute('required'); });
                }
            })();
            </script>
        </div>
    </section>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function checkoutPaymentUi() {
            var selected = document.querySelector('input[name="payment_method"]:checked');
            var code = selected ? selected.value : '';
            document.querySelectorAll('.payment-method-instructions').forEach(function (el) { el.classList.add('hidden'); });
            var instr = document.getElementById('payment-instr-' + code);
            if (instr) { instr.classList.remove('hidden'); }
            var proofWrap = document.getElementById('payment-proof-wrap');
            var proof = document.getElementById('proof');
            var requiresProof = selected && selected.getAttribute('data-requires-proof') === '1';
            if (proofWrap) { proofWrap.classList.toggle('hidden', !requiresProof); }
            if (proof) { proof.required = !!requiresProof; }
        }
        document.querySelectorAll('input[name="payment_method"]').forEach(function (radio) {
            radio.addEventListener('change', checkoutPaymentUi);
        });
        checkoutPaymentUi();
        // When "Use a saved address" is selected, remove required from hidden "new address" fields so validation doesn't block submit.
        (function () {
            var form = document.querySelector('form[action*="checkout.store"]');
            if (!form) return;
            var section = document.getElementById('checkout-billing-new-fields');
            if (!section) return;
            var requiredNames = ['billing_full_name', 'billing_phone_country_code', 'billing_phone_number', 'billing_address_line_1', 'billing_city'];
            function setNewAddressRequired(required) {
                requiredNames.forEach(function (name) {
                    var el = section.querySelector('[name="' + name + '"]');
                    if (el) {
                        if (required) el.setAttribute('required', 'required');
                        else el.removeAttribute('required');
                    }
                });
            }
            function updateFromRadios() {
                var checked = form.querySelector('input[name="billing_use"]:checked');
                setNewAddressRequired(checked ? checked.value === 'new' : true);
            }
            // Use server-rendered initial state so we run before Alpine and avoid hidden required fields
            var initial = form.getAttribute('data-initial-billing-use');
            setNewAddressRequired(initial === 'new');
            // After Alpine may have run, sync again
            setTimeout(updateFromRadios, 100);
            form.querySelectorAll('input[name="billing_use"]').forEach(function (radio) {
                radio.addEventListener('change', updateFromRadios);
            });
        })();
        // Shipping zone change: update displayed shipping and total
        (function () {
            var sel = document.getElementById('shipping_zone_id');
            if (!sel) return;
            var subtotal = parseFloat(sel.getAttribute('data-subtotal')) || 0;
            function updateTotals() {
                var opt = sel.options[sel.selectedIndex];
                var amount = opt ? parseFloat(opt.getAttribute('data-amount')) || 0 : 0;
                var total = subtotal + amount;
                var shipEl = document.getElementById('checkout-shipping');
                var totalEl = document.getElementById('checkout-total');
                if (shipEl) shipEl.textContent = amount > 0 ? amount.toFixed(2) + ' <?php echo e(__("SAR")); ?>' : '<?php echo e(__("Free")); ?>';
                if (totalEl) totalEl.textContent = total.toFixed(2);
            }
            sel.addEventListener('change', updateTotals);
        })();
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/Order\resources/views/frontend/checkout.blade.php ENDPATH**/ ?>