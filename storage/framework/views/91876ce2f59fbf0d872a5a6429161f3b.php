<?php $__env->startSection('title', __('Page content')); ?>
<?php $__env->startSection('heading', __('Page content')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
    <p class="mb-4 text-sm text-gray-600"><?php echo e(__('Edit static pages: Terms, Privacy, Shipping, Return & Refund.')); ?></p>
    <?php $__env->startComponent('components.admin.filter-bar'); ?>
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('Search page name or slug')); ?>" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
    <?php echo $__env->renderComponent(); ?>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-50/80">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Page')); ?></th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Actions')); ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3">
                            <span class="font-medium text-gray-900"><?php echo e($page->page_name); ?></span>
                            <span class="ml-2 font-mono text-xs text-gray-500">/page/<?php echo e($page->page_slug); ?></span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="<?php echo e(route('admin.page-contents.edit', $page)); ?>" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-brand-teal transition hover:bg-brand-gold/10"><?php echo e(__('Edit')); ?></a>
                            <a href="<?php echo e(route('page.show', $page->page_slug)); ?>" target="_blank" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100"><?php echo e(__('View')); ?></a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Page\resources\views\admin\index.blade.php ENDPATH**/ ?>