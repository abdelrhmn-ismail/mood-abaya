
<div class="space-y-8">
    <?php if(session('status') === 'profile-updated'): ?>
        <p class="rounded-lg bg-green-50 px-4 py-2 text-sm text-green-800"><?php echo e(__('Saved.')); ?></p>
    <?php endif; ?>
    <?php if(session('status') === 'password-updated'): ?>
        <p class="rounded-lg bg-green-50 px-4 py-2 text-sm text-green-800"><?php echo e(__('Saved.')); ?></p>
    <?php endif; ?>
    <div class="rounded-xl border border-slate-200 bg-slate-50/30 p-6">
        <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <div class="rounded-xl border border-slate-200 bg-slate-50/30 p-6">
        <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <div class="rounded-xl border border-slate-200 bg-slate-50/30 p-6">
        <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/User\resources/views/frontend/account/account-details-tab.blade.php ENDPATH**/ ?>