
<div class="space-y-6">
    <?php if(session('success')): ?>
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-slate-900"><?php echo e(__('Billing addresses')); ?></h2>
    </div>

    
    <div class="rounded-2xl border border-slate-200 bg-slate-50/50" x-data="{ addFormOpen: <?php echo e(count(old()) ? 'true' : 'false'); ?> }">
        <button type="button" @click="addFormOpen = !addFormOpen" class="flex w-full items-center justify-between px-6 py-4 text-left transition hover:bg-slate-100/80">
            <h3 class="text-lg font-semibold text-slate-900"><?php echo e(__('Add new address')); ?></h3>
            <span class="material-icons text-slate-500 transition" :class="addFormOpen ? 'rotate-180' : ''">expand_more</span>
        </button>
        <div x-show="addFormOpen" x-cloak class="border-t border-slate-200">
            <form action="<?php echo e(route('billing-addresses.store')); ?>" method="POST" class="grid gap-4 p-6 sm:grid-cols-2">
                <?php echo csrf_field(); ?>
                <div class="sm:col-span-2">
                    <label for="addr_label" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Label')); ?> (<?php echo e(__('optional')); ?>)</label>
                    <input type="text" name="label" id="addr_label" value="<?php echo e(old('label')); ?>" placeholder="<?php echo e(__('e.g. Home, Office')); ?>" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                </div>
                <div class="sm:col-span-2">
                    <label for="addr_full_name" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Full name')); ?> *</label>
                    <input type="text" name="full_name" id="addr_full_name" value="<?php echo e(old('full_name', auth()->user()?->name)); ?>" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                    <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="sm:col-span-2">
                    <?php if (isset($component)) { $__componentOriginal7f129feca299ac4c0aa6a1d3bbb99a8a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f129feca299ac4c0aa6a1d3bbb99a8a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.phone-input','data' => ['name' => 'phone','id' => 'addr_phone','value' => old('phone', auth()->user()?->phone),'required' => true,'label' => __('Phone')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('phone-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'phone','id' => 'addr_phone','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('phone', auth()->user()?->phone)),'required' => true,'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Phone'))]); ?>
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
            <div class="sm:col-span-2">
                <label for="addr_line1" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Address line 1')); ?> *</label>
                <input type="text" name="address_line_1" id="addr_line1" value="<?php echo e(old('address_line_1')); ?>" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                <?php $__errorArgs = ['address_line_1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="sm:col-span-2">
                <label for="addr_line2" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Address line 2')); ?> (<?php echo e(__('optional')); ?>)</label>
                <input type="text" name="address_line_2" id="addr_line2" value="<?php echo e(old('address_line_2')); ?>" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            </div>
            <div>
                <label for="addr_city" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('City')); ?> *</label>
                <input type="text" name="city" id="addr_city" value="<?php echo e(old('city')); ?>" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label for="addr_state" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('State / Region')); ?> (<?php echo e(__('optional')); ?>)</label>
                <input type="text" name="state" id="addr_state" value="<?php echo e(old('state')); ?>" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            </div>
            <div>
                <label for="addr_postal" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Postal code')); ?> (<?php echo e(__('optional')); ?>)</label>
                <input type="text" name="postal_code" id="addr_postal" value="<?php echo e(old('postal_code')); ?>" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            </div>
            <div>
                <?php if (isset($component)) { $__componentOriginalb9a1c3d341f3d27f8e92afff6865416a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb9a1c3d341f3d27f8e92afff6865416a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.country-select','data' => ['name' => 'country','id' => 'addr_country','value' => old('country', 'Saudi Arabia'),'label' => __('Country')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('country-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'country','id' => 'addr_country','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('country', 'Saudi Arabia')),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Country'))]); ?>
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
            <div class="flex items-center sm:col-span-2">
                <input type="checkbox" name="is_default" id="addr_default" value="1" <?php echo e(old('is_default') ? 'checked' : (empty($billingAddresses) ? 'checked' : '')); ?> class="rounded border-slate-300 text-slate-900 focus:ring-slate-900/20">
                <label for="addr_default" class="ml-2 text-sm text-slate-700"><?php echo e(__('Set as default')); ?></label>
            </div>
                <div class="sm:col-span-2">
                    <button type="submit" class="rounded-xl bg-brand-teal px-6 py-2.5 font-semibold text-white transition hover:bg-brand-teal-dark"><?php echo e(__('Add address')); ?></button>
                </div>
            </form>
        </div>
    </div>

    
    <?php if(isset($billingAddresses) && $billingAddresses->isNotEmpty()): ?>
        <ul class="grid grid-cols-1 gap-0 divide-y divide-slate-200">
            <?php $__currentLoopData = $billingAddresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="py-4" x-data="{ editing: false }">
                    <div x-show="!editing" class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <?php if($addr->label): ?>
                                <span class="font-semibold text-slate-900"><?php echo e($addr->label); ?></span>
                                <?php if($addr->is_default): ?>
                                    <span class="ml-2 rounded bg-slate-200 px-2 py-0.5 text-xs font-medium text-slate-700"><?php echo e(__('Default')); ?></span>
                                <?php endif; ?>
                                <br>
                            <?php elseif($addr->is_default): ?>
                                <span class="rounded bg-slate-200 px-2 py-0.5 text-xs font-medium text-slate-700"><?php echo e(__('Default')); ?></span>
                                <br>
                            <?php endif; ?>
                            <p class="mt-1 text-sm text-slate-600"><?php echo e($addr->full_name); ?> · <?php echo e($addr->phone); ?></p>
                            <p class="text-sm text-slate-600"><?php echo e($addr->summary); ?></p>
                        </div>
                        <div class="mt-2 flex gap-2 shrink-0 sm:mt-0">
                            <button type="button" @click="editing = true" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"><?php echo e(__('Edit')); ?></button>
                            <form action="<?php echo e(route('billing-addresses.destroy', $addr)); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('Remove this address?')); ?>');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="rounded-lg border border-red-100 bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700 transition hover:bg-red-100"><?php echo e(__('Remove')); ?></button>
                            </form>
                        </div>
                    </div>
                    <div x-show="editing" x-cloak class="rounded-xl border border-slate-200 bg-white p-4">
                        <form action="<?php echo e(route('billing-addresses.update', $addr)); ?>" method="POST" class="grid gap-3 sm:grid-cols-2">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="sm:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Label')); ?></label>
                                <input type="text" name="label" value="<?php echo e(old('label', $addr->label)); ?>" placeholder="<?php echo e(__('e.g. Home')); ?>" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Full name')); ?> *</label>
                                <input type="text" name="full_name" value="<?php echo e(old('full_name', $addr->full_name)); ?>" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div class="sm:col-span-2">
                                <?php if (isset($component)) { $__componentOriginal7f129feca299ac4c0aa6a1d3bbb99a8a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f129feca299ac4c0aa6a1d3bbb99a8a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.phone-input','data' => ['name' => 'phone','id' => 'addr_phone_edit_'.$addr->id,'value' => old('phone', $addr->phone),'required' => true,'label' => __('Phone'),'inputClass' => 'rounded-lg border border-slate-300 px-3 py-2 text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('phone-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'phone','id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('addr_phone_edit_'.$addr->id),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('phone', $addr->phone)),'required' => true,'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Phone')),'inputClass' => 'rounded-lg border border-slate-300 px-3 py-2 text-sm']); ?>
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
                            <div class="sm:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Address line 1')); ?> *</label>
                                <input type="text" name="address_line_1" value="<?php echo e(old('address_line_1', $addr->address_line_1)); ?>" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Address line 2')); ?></label>
                                <input type="text" name="address_line_2" value="<?php echo e(old('address_line_2', $addr->address_line_2)); ?>" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('City')); ?> *</label>
                                <input type="text" name="city" value="<?php echo e(old('city', $addr->city)); ?>" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('State / Region')); ?></label>
                                <input type="text" name="state" value="<?php echo e(old('state', $addr->state)); ?>" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700"><?php echo e(__('Postal code')); ?></label>
                                <input type="text" name="postal_code" value="<?php echo e(old('postal_code', $addr->postal_code)); ?>" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div>
                                <?php if (isset($component)) { $__componentOriginalb9a1c3d341f3d27f8e92afff6865416a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb9a1c3d341f3d27f8e92afff6865416a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.country-select','data' => ['name' => 'country','id' => 'addr_country_edit_'.$addr->id,'value' => old('country', $addr->country),'label' => __('Country')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('country-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'country','id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('addr_country_edit_'.$addr->id),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('country', $addr->country)),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Country'))]); ?>
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
                            <div class="flex items-center sm:col-span-2">
                                <input type="checkbox" name="is_default" value="1" <?php echo e($addr->is_default ? 'checked' : ''); ?> class="rounded border-slate-300 text-slate-900">
                                <label class="ml-2 text-sm text-slate-700"><?php echo e(__('Set as default')); ?></label>
                            </div>
                            <div class="flex gap-2 sm:col-span-2">
                                <button type="submit" class="rounded-lg bg-brand-teal px-4 py-2 text-sm font-semibold text-white hover:bg-brand-teal-dark"><?php echo e(__('Save')); ?></button>
                                <button type="button" @click="editing = false" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"><?php echo e(__('Cancel')); ?></button>
                            </div>
                        </form>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php else: ?>
        <p class="rounded-xl border border-slate-200 bg-slate-50/50 p-6 text-center text-slate-600"><?php echo e(__('No saved addresses yet. Add one above or at checkout.')); ?></p>
    <?php endif; ?>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/User\resources/views/frontend/account/addresses-tab.blade.php ENDPATH**/ ?>