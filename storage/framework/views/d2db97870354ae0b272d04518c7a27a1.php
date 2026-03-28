<section>
    <h2 class="text-lg font-semibold text-slate-900"><?php echo e(__('Update Password')); ?></h2>
    <p class="mt-1 text-sm text-slate-600"><?php echo e(__('Ensure your account is using a long, random password to stay secure.')); ?></p>

    <form method="post" action="<?php echo e(route('password.update')); ?>" class="mt-6 space-y-5">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>

        <div>
            <label for="update_password_current_password" class="mb-2 block text-sm font-medium text-slate-700"><?php echo e(__('Current Password')); ?></label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                   class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            <?php if($errors->updatePassword->has('current_password')): ?>
                <p class="mt-1 text-sm text-red-600"><?php echo e($errors->updatePassword->first('current_password')); ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="update_password_password" class="mb-2 block text-sm font-medium text-slate-700"><?php echo e(__('New Password')); ?></label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                   class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            <?php if($errors->updatePassword->has('password')): ?>
                <p class="mt-1 text-sm text-red-600"><?php echo e($errors->updatePassword->first('password')); ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="update_password_password_confirmation" class="mb-2 block text-sm font-medium text-slate-700"><?php echo e(__('Confirm Password')); ?></label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                   class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            <?php if($errors->updatePassword->has('password_confirmation')): ?>
                <p class="mt-1 text-sm text-red-600"><?php echo e($errors->updatePassword->first('password_confirmation')); ?></p>
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="rounded-xl bg-brand-teal px-5 py-2.5 font-semibold text-white hover:bg-brand-teal-dark focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2">
                <?php echo e(__('Save')); ?>

            </button>
            <?php if(session('status') === 'password-updated'): ?>
                <p class="text-sm text-slate-600"><?php echo e(__('Saved.')); ?></p>
            <?php endif; ?>
        </div>
    </form>
</section>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\profile\partials\update-password-form.blade.php ENDPATH**/ ?>