<section class="space-y-6">
    <h2 class="text-lg font-semibold text-slate-900"><?php echo e(__('Delete Account')); ?></h2>
    <p class="text-sm text-slate-600">
        <?php echo e(__('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.')); ?>

    </p>

    <button type="button" x-data="" @click="$dispatch('open-modal', 'confirm-user-deletion')"
            class="rounded-xl border border-red-300 bg-white px-5 py-2.5 font-semibold text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
        <?php echo e(__('Delete Account')); ?>

    </button>

    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'confirm-user-deletion','show' => $errors->userDeletion->isNotEmpty(),'focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'confirm-user-deletion','show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->userDeletion->isNotEmpty()),'focusable' => true]); ?>
        <form method="post" action="<?php echo e(route('profile.destroy')); ?>" class="p-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('delete'); ?>

            <h2 class="text-lg font-semibold text-slate-900"><?php echo e(__('Are you sure you want to delete your account?')); ?></h2>
            <p class="mt-2 text-sm text-slate-600">
                <?php echo e(__('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.')); ?>

            </p>

            <div class="mt-6">
                <label for="password" class="sr-only"><?php echo e(__('Password')); ?></label>
                <input id="password" name="password" type="password" placeholder="<?php echo e(__('Password')); ?>"
                       class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                <?php if($errors->userDeletion->has('password')): ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($errors->userDeletion->first('password')); ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-6 flex flex-wrap justify-end gap-3">
                <button type="button" @click="$dispatch('close-modal', 'confirm-user-deletion')"
                        class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2">
                    <?php echo e(__('Cancel')); ?>

                </button>
                <button type="submit" class="rounded-xl bg-red-600 px-5 py-2.5 font-semibold text-white hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <?php echo e(__('Delete Account')); ?>

                </button>
            </div>
        </form>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
</section>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\profile\partials\delete-user-form.blade.php ENDPATH**/ ?>