
<div class="space-y-6">
    <h2 class="text-lg font-semibold text-slate-900"><?php echo e(__('Dashboard')); ?></h2>
    <p class="text-sm text-slate-600">
        <?php echo e(__('Hello :name', ['name' => $user->name])); ?> —
        <?php echo e(__('From your account dashboard you can view your recent orders and manage your details.')); ?>

    </p>
    <dl class="grid gap-4 text-sm text-slate-600 md:grid-cols-2">
        <div>
            <dt class="font-medium text-slate-900"><?php echo e(__('Your Name')); ?></dt>
            <dd><?php echo e($user->name); ?></dd>
        </div>
        <div>
            <dt class="font-medium text-slate-900"><?php echo e(__('Your Email')); ?></dt>
            <dd><?php echo e($user->email); ?></dd>
        </div>
        <?php if($user->phone): ?>
            <div>
                <dt class="font-medium text-slate-900"><?php echo e(__('Phone')); ?></dt>
                <dd><?php echo e($user->phone); ?></dd>
            </div>
        <?php endif; ?>
    </dl>
    <button type="button" @click="tab = 'account-details'"
            class="rounded-xl bg-brand-teal px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-teal-dark">
        <?php echo e(__('Edit Profile')); ?>

    </button>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/User\resources/views/frontend/account/dashboard-tab.blade.php ENDPATH**/ ?>