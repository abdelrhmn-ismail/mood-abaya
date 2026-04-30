<?php $__env->startSection('title', __('Payment methods')); ?>
<?php $__env->startSection('heading', __('Payment methods')); ?>

<?php $__env->startSection('content'); ?>


<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
    <div class="mb-4 flex items-center gap-3">
        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-purple-100">
            <span class="material-icons text-purple-600 text-lg">integration_instructions</span>
        </div>
        <div>
            <h2 class="text-base font-semibold text-gray-900"><?php echo e(__('Payment gateway integrations')); ?></h2>
            <p class="text-sm text-gray-500"><?php echo e(__('Integrated payment gateways. These cannot be removed — only activated or deactivated. Click settings to configure API keys.')); ?></p>
        </div>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-50/80">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Gateway')); ?></th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Name')); ?></th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Status')); ?></th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Actions')); ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php $__currentLoopData = $gatewayMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <?php if($gm->code === 'tabby'): ?>
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100">
                                        <span class="material-icons text-emerald-600 text-sm">credit_score</span>
                                    </div>
                                <?php else: ?>
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100">
                                        <span class="material-icons text-blue-600 text-sm">payment</span>
                                    </div>
                                <?php endif; ?>
                                <span class="font-mono text-sm text-gray-900"><?php echo e($gm->code); ?></span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($gm->name_en); ?></td>
                        <td class="px-4 py-3">
                            <?php if($gm->is_active): ?>
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
                            <form action="<?php echo e(route('admin.payment-methods.toggle', $gm)); ?>" method="POST" class="mt-2 inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-xs font-medium text-brand-teal hover:underline"><?php echo e($gm->is_active ? __('Turn off') : __('Turn on')); ?></button>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-right text-sm">
                            <?php if($gm->code === 'tabby'): ?>
                                <a href="<?php echo e(route('admin.tabby-settings.edit')); ?>" class="inline-flex items-center gap-1 rounded-lg px-3 py-2 font-medium text-brand-teal transition hover:bg-brand-gold/10">
                                    <span class="material-icons text-base">settings</span> <?php echo e(__('Settings')); ?>

                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($gatewayMethods->isEmpty()): ?>
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-400"><?php echo e(__('No gateway integrations available.')); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php echo $__env->renderComponent(); ?>


<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
    <div class="mb-4 flex items-center gap-3">
        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100">
            <span class="material-icons text-blue-600 text-lg">account_balance</span>
        </div>
        <div>
            <h2 class="text-base font-semibold text-gray-900"><?php echo e(__('Manual payment methods')); ?></h2>
            <p class="text-sm text-gray-500"><?php echo e(__('Enable or disable methods, edit labels, and set bank details shown at checkout. Add custom gateways when you integrate new providers.')); ?></p>
        </div>
    </div>
    <div class="mb-4">
        <a href="<?php echo e(route('admin.payment-methods.create')); ?>" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-teal-dark">
            <span class="material-icons text-lg">add</span> <?php echo e(__('Add payment method')); ?>

        </a>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-50/80">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Sort')); ?></th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Code')); ?></th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Name (EN)')); ?></th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Status')); ?></th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Behavior')); ?></th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Actions')); ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($m->sort_order); ?></td>
                        <td class="px-4 py-3 font-mono text-sm text-gray-900"><?php echo e($m->code); ?></td>
                        <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($m->name_en); ?></td>
                        <td class="px-4 py-3">
                            <?php if($m->is_active): ?>
                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800"><?php echo e(__('Active')); ?></span>
                            <?php else: ?>
                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600"><?php echo e(__('Inactive')); ?></span>
                            <?php endif; ?>
                            <form action="<?php echo e(route('admin.payment-methods.toggle', $m)); ?>" method="POST" class="mt-2 inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-xs font-medium text-brand-teal hover:underline"><?php echo e($m->is_active ? __('Turn off') : __('Turn on')); ?></button>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">
                            <?php if($m->requires_proof): ?><span class="mr-2 inline-block rounded bg-slate-100 px-2 py-0.5"><?php echo e(__('Receipt upload')); ?></span><?php endif; ?>
                            <?php if($m->requires_admin_approval): ?><span class="inline-block rounded bg-amber-100 px-2 py-0.5 text-amber-900"><?php echo e(__('Admin approval')); ?></span><?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-right text-sm">
                            <a href="<?php echo e(route('admin.payment-methods.edit', $m)); ?>" class="inline-flex items-center gap-1 rounded-lg px-3 py-2 font-medium text-brand-teal transition hover:bg-brand-gold/10"><?php echo e(__('Edit')); ?></a>
                            <?php if(!$m->is_system): ?>
                                <form action="<?php echo e(route('admin.payment-methods.destroy', $m)); ?>" method="POST" class="inline-block" onsubmit="return confirm('<?php echo e(__('Delete this payment method?')); ?>');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="inline-flex items-center gap-1 rounded-lg px-3 py-2 font-medium text-red-600 transition hover:bg-red-50"><?php echo e(__('Delete')); ?></button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules/Payment\resources/views/admin/payment-methods/index.blade.php ENDPATH**/ ?>