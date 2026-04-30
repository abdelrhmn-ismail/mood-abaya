<?php $__env->startSection('title', __('Tabby Settings')); ?>
<?php $__env->startSection('heading', __('Tabby Settings')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100">
                <span class="material-icons text-emerald-600">credit_score</span>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900"><?php echo e(__('Tabby Payment Gateway')); ?></h2>
                <p class="text-sm text-gray-500"><?php echo e(__('Configure your Tabby API credentials for Buy Now Pay Later integration.')); ?></p>
            </div>
        </div>
        <?php if($method): ?>
            <div class="mt-3 flex items-center gap-2">
                <span class="text-sm font-medium text-gray-600"><?php echo e(__('Status:')); ?></span>
                <?php if($method->is_active): ?>
                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                        <?php echo e(__('Active')); ?>

                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">
                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                        <?php echo e(__('Inactive')); ?>

                    </span>
                <?php endif; ?>
                <form action="<?php echo e(route('admin.payment-methods.toggle', $method)); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-xs font-medium text-brand-teal hover:underline"><?php echo e($method->is_active ? __('Turn off') : __('Turn on')); ?></button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <form action="<?php echo e(route('admin.tabby-settings.update')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="rounded-xl border border-gray-200 bg-slate-50/50 p-5 space-y-5">
            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-600"><?php echo e(__('API Credentials')); ?></h3>

            <?php echo $__env->make('components.admin.form-field', [
                'name'  => 'public_key',
                'label' => __('Public API Key'),
                'type'  => 'text',
                'value' => old('public_key', $settings['public_key'] ?? ''),
                'required' => true,
                'attributes' => ['placeholder' => 'pk_test_...', 'autocomplete' => 'off'],
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php echo $__env->make('components.admin.form-field', [
                'name'  => 'secret_key',
                'label' => __('Secret API Key'),
                'type'  => 'text',
                'value' => old('secret_key', $settings['secret_key'] ?? ''),
                'required' => true,
                'attributes' => ['placeholder' => 'sk_test_...', 'autocomplete' => 'off'],
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php echo $__env->make('components.admin.form-field', [
                'name'  => 'merchant_code',
                'label' => __('Merchant Code'),
                'type'  => 'text',
                'value' => old('merchant_code', $settings['merchant_code'] ?? ''),
                'required' => true,
                'attributes' => ['placeholder' => 'e.g. MD'],
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="rounded-xl border border-amber-200 bg-amber-50/50 p-4">
            <div class="flex items-start gap-2">
                <span class="material-icons text-amber-500 text-lg mt-0.5">info</span>
                <div class="text-sm text-amber-800">
                    <p class="font-medium"><?php echo e(__('Important Notes')); ?></p>
                    <ul class="mt-1 list-disc list-inside space-y-0.5 text-xs text-amber-700">
                        <li><?php echo e(__('Use test keys (pk_test_ / sk_test_) for testing, live keys (pk_live_ / sk_live_) for production.')); ?></li>
                        <li><?php echo e(__('Tabby webhook URL:')); ?> <code class="rounded bg-amber-100 px-1 py-0.5 font-mono text-xs"><?php echo e(route('tabby.webhook')); ?></code></li>
                        <li><?php echo e(__('Make sure to register the webhook URL in your Tabby dashboard.')); ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <?php echo $__env->make('components.admin.form-actions', [
            'submitLabel' => __('Save Tabby settings'),
            'cancelUrl'   => route('admin.payment-methods.index'),
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </form>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/Payment\resources/views/admin/tabby-settings.blade.php ENDPATH**/ ?>