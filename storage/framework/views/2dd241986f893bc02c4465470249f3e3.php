<?php $__env->startSection('title', __('Testimonials')); ?>
<?php $__env->startSection('heading', __('Testimonials')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
    <p class="mb-4 text-sm text-gray-600"><?php echo e(__('Customer quotes shown on the home and about pages.')); ?></p>
    <div class="mb-4">
        <a href="<?php echo e(route('admin.testimonials.create')); ?>" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-teal-dark">
            <span class="material-icons text-lg">add</span> <?php echo e(__('Add testimonial')); ?>

        </a>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-50/80">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Name')); ?></th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Quote')); ?></th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Order')); ?></th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Status')); ?></th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Actions')); ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3 font-medium text-gray-900"><?php echo e($t->name); ?></td>
                        <td class="px-4 py-3 text-sm text-gray-600"><?php echo e(Str::limit($t->quote, 80)); ?></td>
                        <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($t->sort_order); ?></td>
                        <td class="px-4 py-3">
                            <?php if($t->active): ?>
                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800"><?php echo e(__('Active')); ?></span>
                            <?php else: ?>
                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600"><?php echo e(__('Inactive')); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="<?php echo e(route('admin.testimonials.edit', $t)); ?>" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-brand-teal transition hover:bg-brand-gold/10"><?php echo e(__('Edit')); ?></a>
                            <form action="<?php echo e(route('admin.testimonials.destroy', $t)); ?>" method="POST" class="inline-block" onsubmit="return confirm('<?php echo e(__('Are you sure you want to delete this testimonial?')); ?>');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50"><?php echo e(__('Delete')); ?></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500"><?php echo e(__('No testimonials yet.')); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Testimonial\resources\views\admin\index.blade.php ENDPATH**/ ?>