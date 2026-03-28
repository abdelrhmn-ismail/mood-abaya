<?php $__env->startSection('title', __('Reviews')); ?>
<?php $__env->startSection('heading', __('Reviews')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
    <?php if(session('success')): ?>
        <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <p class="mb-4 text-sm text-gray-500"><?php echo e(__('Product reviews from completed orders. Hide a review to prevent it from showing on the product page.')); ?></p>

    <?php $__env->startComponent('components.admin.filter-bar'); ?>
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('Search comment')); ?>" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <select name="rating" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
            <option value=""><?php echo e(__('All ratings')); ?></option>
            <?php for($r = 1; $r <= 5; $r++): ?>
                <option value="<?php echo e($r); ?>" <?php echo e(request('rating') === (string)$r ? 'selected' : ''); ?>><?php echo e($r); ?> ★</option>
            <?php endfor; ?>
        </select>
        <select name="visible" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
            <option value=""><?php echo e(__('All visibility')); ?></option>
            <option value="1" <?php echo e(request('visible') === '1' ? 'selected' : ''); ?>><?php echo e(__('Visible')); ?></option>
            <option value="0" <?php echo e(request('visible') === '0' ? 'selected' : ''); ?>><?php echo e(__('Hidden')); ?></option>
        </select>
        <select name="product_id" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
            <option value=""><?php echo e(__('All products')); ?></option>
            <?php $__currentLoopData = $products ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p->id); ?>" <?php echo e(request('product_id') == $p->id ? 'selected' : ''); ?>><?php echo e($p->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    <?php echo $__env->renderComponent(); ?>

    <form method="POST" action="<?php echo e(route('admin.reviews.bulk')); ?>" id="reviews-bulk-form">
        <?php echo csrf_field(); ?>
        <div class="mb-3 flex flex-wrap items-center gap-3 rounded-lg border border-gray-200 bg-slate-50/50 px-4 py-2">
            <span class="text-sm text-slate-600" data-bulk-count><?php echo e(__('Select rows below, then choose an action.')); ?></span>
            <select name="action" required class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
                <option value=""><?php echo e(__('Bulk action')); ?></option>
                <option value="show"><?php echo e(__('Show')); ?></option>
                <option value="hide"><?php echo e(__('Hide')); ?></option>
                <option value="delete"><?php echo e(__('Delete')); ?></option>
            </select>
            <button type="submit" class="rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white hover:bg-brand-teal-dark" data-bulk-apply><?php echo e(__('Apply')); ?></button>
        </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-slate-50/80">
                    <th class="w-10 px-3 py-3">
                        <input type="checkbox" class="reviews-select-all rounded border-gray-300 text-brand-teal focus:ring-brand-teal" aria-label="<?php echo e(__('Select all')); ?>">
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600"><?php echo e(__('Product')); ?></th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600"><?php echo e(__('User')); ?></th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600"><?php echo e(__('Order')); ?></th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        <a href="<?php echo e(admin_sort_url('rating')); ?>" class="inline-flex items-center gap-1 transition hover:text-brand-teal">
                            <?php echo e(__('Rating')); ?>

                            <?php if(request('sort') === 'rating'): ?>
                                <span class="material-icons text-base"><?php echo e(request('order', 'desc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down'); ?></span>
                            <?php else: ?>
                                <span class="material-icons text-base opacity-50">unfold_more</span>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600"><?php echo e(__('Comment')); ?></th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        <a href="<?php echo e(admin_sort_url('is_visible')); ?>" class="inline-flex items-center gap-1 transition hover:text-brand-teal">
                            <?php echo e(__('Visible')); ?>

                            <?php if(request('sort') === 'is_visible'): ?>
                                <span class="material-icons text-base"><?php echo e(request('order', 'desc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down'); ?></span>
                            <?php else: ?>
                                <span class="material-icons text-base opacity-50">unfold_more</span>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-gray-600">
                        <a href="<?php echo e(admin_sort_url('created_at')); ?>" class="inline-flex items-center gap-1 transition hover:text-brand-teal ml-auto">
                            <?php echo e(__('Date')); ?>

                            <?php if(request('sort') === 'created_at' || !request('sort')): ?>
                                <span class="material-icons text-base"><?php echo e(request('order', 'desc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down'); ?></span>
                            <?php else: ?>
                                <span class="material-icons text-base opacity-50">unfold_more</span>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase text-gray-600"><?php echo e(__('Actions')); ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50">
                        <td class="w-10 px-3 py-3">
                            <input type="checkbox" name="ids[]" value="<?php echo e($review->id); ?>" class="reviews-row-cb rounded border-gray-300 text-brand-teal focus:ring-brand-teal">
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <a href="<?php echo e(route('admin.products.edit', $review->product)); ?>" class="font-medium text-brand-teal hover:underline"><?php echo e($review->product?->name ?? '—'); ?></a>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($review->user?->name ?? '—'); ?></td>
                        <td class="px-4 py-3 font-mono text-sm text-gray-700"><?php echo e($review->order?->order_number ?? '—'); ?></td>
                        <td class="px-4 py-3 text-sm">
                            <?php for($s = 1; $s <= 5; $s++): ?>
                                <span class="text-amber-500"><?php echo e($s <= $review->rating ? '★' : '☆'); ?></span>
                            <?php endfor; ?>
                        </td>
                        <td class="max-w-xs px-4 py-3 text-sm text-gray-600 truncate" title="<?php echo e($review->comment); ?>"><?php echo e(Str::limit($review->comment, 50) ?: '—'); ?></td>
                        <td class="px-4 py-3 text-sm">
                            <?php if($review->is_visible): ?>
                                <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800"><?php echo e(__('Yes')); ?></span>
                            <?php else: ?>
                                <span class="rounded-full bg-gray-200 px-2 py-0.5 text-xs font-medium text-gray-600"><?php echo e(__('Hidden')); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($review->created_at?->format('Y-m-d H:i') ?? '—'); ?></td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" class="rounded-lg px-3 py-2 text-sm font-medium admin-review-toggle <?php echo e($review->is_visible ? 'text-amber-600 hover:bg-amber-50' : 'text-green-600 hover:bg-green-50'); ?>" data-url="<?php echo e(route('admin.reviews.toggle-visibility', $review)); ?>">
                                <?php echo e($review->is_visible ? __('Hide') : __('Show')); ?>

                            </button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center text-gray-500"><?php echo e(__('No reviews yet.')); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    </form>
    <script>
    (function() {
        function run() {
            var form = document.getElementById('reviews-bulk-form');
            if (!form) return;
            var selectAll = form.querySelector('.reviews-select-all');
            var checkboxes = form.querySelectorAll('.reviews-row-cb');
            var countEl = form.querySelector('[data-bulk-count]');
            var applyBtn = form.querySelector('[data-bulk-apply]');
            function updateCount() {
                var n = form.querySelectorAll('.reviews-row-cb:checked').length;
                if (countEl) countEl.textContent = n ? (n + ' <?php echo e(__('selected')); ?>') : '<?php echo e(__('Select rows below, then choose an action.')); ?>';
                if (applyBtn) applyBtn.disabled = !n;
            }
            if (selectAll) selectAll.addEventListener('change', function() {
                checkboxes.forEach(function(cb) { cb.checked = selectAll.checked; });
                updateCount();
            });
            checkboxes.forEach(function(cb) { cb.addEventListener('change', updateCount); });
            form.addEventListener('submit', function(e) {
                if (!form.querySelector('.reviews-row-cb:checked').length) {
                    e.preventDefault();
                    alert('<?php echo e(__("Please select at least one row.")); ?>');
                    return false;
                }
                if (form.querySelector('select[name="action"]').value === 'delete' && !confirm('<?php echo e(__("Are you sure you want to delete the selected records?")); ?>')) {
                    e.preventDefault();
                    return false;
                }
            });
            updateCount();
        }
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', run);
        else run();
    })();
    (function() {
        if (window.__adminReviewToggleBound) return;
        window.__adminReviewToggleBound = true;
        document.body.addEventListener('click', function(e) {
            var btn = e.target.closest('.admin-review-toggle');
            if (!btn) return;
            e.preventDefault();
            var url = btn.getAttribute('data-url');
            if (!url) return;
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            var csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            var meta = document.querySelector('meta[name="csrf-token"]');
            csrf.value = meta ? meta.getAttribute('content') : '';
            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
        });
    })();
    </script>
    <?php if($reviews->hasPages()): ?>
        <div class="mt-4"><?php echo e($reviews->withQueryString()->links()); ?></div>
    <?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Shop\resources\views\admin\reviews\index.blade.php ENDPATH**/ ?>