<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if(session('status')): ?>
        <div class="mb-6 rounded-xl bg-green-100 px-4 py-3 text-sm text-green-800"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <h1 class="text-2xl font-bold text-slate-900"><?php echo e(__('Log in')); ?></h1>
    <p class="mt-1 text-sm text-slate-600"><?php echo e(__('Sign in to your account')); ?></p>

    <form method="POST" action="<?php echo e(route('login')); ?>" class="mt-8 space-y-5">
        <?php echo csrf_field(); ?>

        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-slate-700"><?php echo e(__('Email')); ?></label>
            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username"
                   class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="password" class="mb-2 block text-sm font-medium text-slate-700"><?php echo e(__('Password')); ?></label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                   class="rounded border-slate-300 text-slate-900 focus:ring-slate-900/20">
            <label for="remember_me" class="ms-2 text-sm text-slate-600"><?php echo e(__('Remember me')); ?></label>
        </div>

        <div class="flex flex-col gap-4 pt-2 sm:flex-row sm:items-center sm:justify-between">
            <a href="<?php echo e(route('register')); ?>" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition">
                <?php echo e(__('Need to register?')); ?>

            </a>
            <button type="submit" class="w-full rounded-xl bg-brand-teal px-6 py-3 font-semibold text-white transition hover:bg-brand-teal-dark focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2 sm:w-auto">
                <?php echo e(__('Log in')); ?>

            </button>
        </div>
    </form>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\auth\login.blade.php ENDPATH**/ ?>