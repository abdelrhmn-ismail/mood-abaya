

<?php $__env->startSection('title', __('FAQ')); ?>
<?php $__env->startSection('heading', __('FAQ')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
    <p class="mb-4 text-sm text-gray-600"><?php echo e(__('Manage questions and answers shown on the Contact page.')); ?></p>
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <span class="text-sm text-gray-500"><?php echo e($faqs->count()); ?> <?php echo e(__('items')); ?></span>
        <a href="<?php echo e(route('admin.faqs.create')); ?>" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-teal-dark">
            <span class="material-icons text-lg">add</span> <?php echo e(__('Add FAQ')); ?>

        </a>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-50/80">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Order')); ?></th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Question')); ?></th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Status')); ?></th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Actions')); ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php $__empty_1 = true; $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($faq->sort_order); ?></td>
                        <td class="px-4 py-3">
                            <span class="font-medium text-gray-900"><?php echo e(Str::limit($faq->question_en, 60)); ?></span>
                        </td>
                        <td class="px-4 py-3">
                            <?php if($faq->is_active): ?>
                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800"><?php echo e(__('Active')); ?></span>
                            <?php else: ?>
                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600"><?php echo e(__('Inactive')); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="<?php echo e(route('admin.faqs.edit', $faq)); ?>" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-brand-teal transition hover:bg-brand-gold/10"><?php echo e(__('Edit')); ?></a>
                            <form action="<?php echo e(route('admin.faqs.destroy', $faq)); ?>" method="POST" class="inline-block" onsubmit="return confirm('<?php echo e(__('Are you sure you want to delete this FAQ?')); ?>');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50"><?php echo e(__('Delete')); ?></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500"><?php echo e(__('No FAQs yet. Add one to show on the Contact page.')); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Faq\resources\views\admin\index.blade.php ENDPATH**/ ?>