<section>
    <h2 class="text-lg font-semibold text-slate-900"><?php echo e(__('Profile Information')); ?></h2>
    <p class="mt-1 text-sm text-slate-600"><?php echo e(__("Update your account's profile information and email address.")); ?></p>

    <form id="send-verification" method="post" action="<?php echo e(route('verification.send')); ?>">
        <?php echo csrf_field(); ?>
    </form>

    <form method="post" action="<?php echo e(route('profile.update')); ?>" class="mt-6 space-y-5">
        <?php echo csrf_field(); ?>
        <?php echo method_field('patch'); ?>

        <div>
            <label for="name" class="mb-2 block text-sm font-medium text-slate-700"><?php echo e(__('Name')); ?></label>
            <input id="name" name="name" type="text" value="<?php echo e(old('name', $user->name)); ?>" required autofocus autocomplete="name"
                   class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            <?php $__errorArgs = ['name'];
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
            <label for="email" class="mb-2 block text-sm font-medium text-slate-700"><?php echo e(__('Email')); ?></label>
            <input id="email" name="email" type="email" value="<?php echo e(old('email', $user->email)); ?>" required autocomplete="username"
                   class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
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

            <?php if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail()): ?>
                <div class="mt-3">
                    <p class="text-sm text-slate-600">
                        <?php echo e(__('Your email address is unverified.')); ?>

                        <button form="send-verification" type="submit" class="font-medium text-slate-900 hover:underline">
                            <?php echo e(__('Click here to re-send the verification email.')); ?>

                        </button>
                    </p>
                    <?php if(session('status') === 'verification-link-sent'): ?>
                        <p class="mt-2 text-sm font-medium text-green-600"><?php echo e(__('A new verification link has been sent to your email address.')); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="rounded-xl bg-brand-teal px-5 py-2.5 font-semibold text-white hover:bg-brand-teal-dark focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2">
                <?php echo e(__('Save')); ?>

            </button>
            <?php if(session('status') === 'profile-updated'): ?>
                <p class="text-sm text-slate-600"><?php echo e(__('Saved.')); ?></p>
            <?php endif; ?>
        </div>
    </form>
</section>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\profile\partials\update-profile-information-form.blade.php ENDPATH**/ ?>