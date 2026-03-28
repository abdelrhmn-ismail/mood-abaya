<?php
    $columns = $columns ?? [];
    $rows = $rows ?? collect();
    $emptyMessage = $emptyMessage ?? __('No records found.');
    $actions = $actions ?? [];
    $pagination = $pagination ?? null;
    $rowHighlightKey = $rowHighlightKey ?? null;   // e.g. 'read_at' – when empty, row gets highlighted
    $rowHighlightClass = $rowHighlightClass ?? 'bg-blue-50/50';
    $bulk_actions = $bulk_actions ?? [];          // e.g. [['value' => 'activate', 'label' => 'Activate'], ...]
    $bulk_form_action = $bulk_form_action ?? null; // route or url for POST
    $row_key = $row_key ?? 'id';
    $hasActions = !empty($actions) && (!empty($actions['view_route']) || !empty($actions['edit_route']) || !empty($actions['delete_route']));
    $hasBulk = !empty($bulk_actions) && !empty($bulk_form_action);
    $colCount = count($columns) + ($hasActions ? 1 : 0) + ($hasBulk ? 1 : 0);

    $getCellValue = function ($row, $col) {
        $key = $col['key'] ?? null;
        $key2 = $col['key2'] ?? null;
        $format = $col['format'] ?? null;
        $glue = $col['glue'] ?? ' / ';
        $translate = !empty($col['translate']);

        $val = $key !== null ? data_get($row, $key) : '';
        if ($key2 !== null) {
            $val2 = data_get($row, $key2);
            $val = $translate ? (__($val) . $glue . __($val2)) : ($val . $glue . $val2);
        } elseif ($translate && $val !== null && $val !== '') {
            $val = __($val);
        }

        if ($format === 'datetime' && $val && is_object($val) && method_exists($val, 'format')) {
            return $val->format('Y-m-d H:i');
        }
        if ($format === 'price' && $val !== null && $val !== '') {
            return number_format((float) $val, 2) . ' ' . __('SAR');
        }
        if ($format === 'boolean') {
            return $val ? __('Yes') : __('No');
        }
        $limit = $col['limit'] ?? null;
        if ($limit !== null && is_string($val)) {
            $val = \Illuminate\Support\Str::limit($val, (int) $limit);
        }
        if ($val === null || $val === '') {
            return '—';
        }
        return $val;
    };
?>

<?php if($hasBulk): ?>
<form method="POST" action="<?php echo e($bulk_form_action); ?>" id="bulk-form-<?php echo e(md5($bulk_form_action ?? '')); ?>" class="bulk-form">
    <?php echo csrf_field(); ?>
    <div class="flex flex-wrap items-center gap-3 border-b border-gray-200 bg-slate-50/50 px-5 py-3">
        <span class="text-sm text-slate-600" data-bulk-count><?php echo e(__('Select rows below, then choose an action.')); ?></span>
        <select name="action" required class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
            <option value=""><?php echo e(__('Bulk action')); ?></option>
            <?php $__currentLoopData = $bulk_actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($opt['value'] ?? $opt[0]); ?>"><?php echo e($opt['label'] ?? $opt[1] ?? $opt['value'] ?? $opt[0]); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button type="submit" class="rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white hover:bg-brand-teal-dark" data-bulk-apply><?php echo e(__('Apply')); ?></button>
    </div>
<?php endif; ?>
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-slate-50/80">
                    <?php if($hasBulk): ?>
                        <th scope="col" class="w-10 px-3 py-4">
                            <input type="checkbox" class="bulk-select-all rounded border-gray-300 text-brand-teal focus:ring-brand-teal" aria-label="<?php echo e(__('Select all')); ?>">
                        </th>
                    <?php endif; ?>
                    <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $sortKey = $col['sort_key'] ?? null;
                            $isSortable = $sortKey !== null;
                            $isActiveSort = $isSortable && request('sort') === $sortKey;
                            $currentOrder = request('order', 'desc');
                        ?>
                        <th scope="col" class="px-5 py-4 text-start text-xs font-semibold uppercase tracking-wider text-slate-600 <?php echo e($isSortable ? 'whitespace-nowrap' : ''); ?>">
                            <?php if($isSortable): ?>
                                <a href="<?php echo e(admin_sort_url($sortKey)); ?>" class="inline-flex items-center gap-1 transition hover:text-brand-teal">
                                    <?php echo e($col['label'] ?? ''); ?>

                                    <?php if($isActiveSort): ?>
                                        <span class="material-icons text-base" aria-hidden="true"><?php echo e($currentOrder === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down'); ?></span>
                                    <?php else: ?>
                                        <span class="material-icons text-base opacity-50" aria-hidden="true">unfold_more</span>
                                    <?php endif; ?>
                                </a>
                            <?php else: ?>
                                <?php echo e($col['label'] ?? ''); ?>

                            <?php endif; ?>
                        </th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($hasActions): ?>
                        <th scope="col" class="relative px-5 py-4 text-end text-xs font-semibold uppercase tracking-wider text-slate-600">
                            <?php echo e(__('Actions')); ?>

                        </th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $rowClass = 'bg-white transition-colors hover:bg-slate-50/70';
                        if ($rowHighlightKey !== null && empty(data_get($row, $rowHighlightKey))) {
                            $rowClass .= ' ' . $rowHighlightClass;
                        }
                    ?>
                    <tr class="<?php echo e($rowClass); ?>">
                        <?php if($hasBulk): ?>
                            <td class="w-10 px-3 py-4">
                                <input type="checkbox" name="ids[]" value="<?php echo e(data_get($row, $row_key)); ?>" class="bulk-row-checkbox rounded border-gray-300 text-brand-teal focus:ring-brand-teal">
                            </td>
                        <?php endif; ?>
                        <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td class="whitespace-nowrap px-5 py-4 text-start text-sm text-slate-800 <?php echo e($col['class'] ?? ''); ?>">
                                <?php echo e($getCellValue($row, $col)); ?>

                            </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($hasActions): ?>
                            <td class="relative whitespace-nowrap px-5 py-4 text-end">
                                <div class="flex items-center justify-end gap-1">
                                    <?php if(!empty($actions['view_route'])): ?>
                                        <a href="<?php echo e(route($actions['view_route'], $row)); ?>" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900" title="<?php echo e(__('View')); ?>">
                                            <span class="material-icons text-lg">visibility</span>
                                            <span class="hidden sm:inline text-sm font-medium"><?php echo e(__('View')); ?></span>
                                        </a>
                                    <?php endif; ?>
                                    <?php if(!empty($actions['edit_route'])): ?>
                                        <a href="<?php echo e(route($actions['edit_route'], $row)); ?>" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-brand-teal transition hover:bg-brand-gold/10" title="<?php echo e(__('Edit')); ?>">
                                            <span class="material-icons text-lg">edit</span>
                                            <span class="hidden sm:inline text-sm font-medium"><?php echo e(__('Edit')); ?></span>
                                        </a>
                                    <?php endif; ?>
                                    <?php if(!empty($actions['delete_route'])): ?>
                                        <button type="button" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-red-600 transition hover:bg-red-50 admin-delete-one" title="<?php echo e(__('Delete')); ?>" data-delete-url="<?php echo e(route($actions['delete_route'], $row)); ?>" data-delete-confirm="<?php echo e($actions['delete_confirm'] ?? __('Are you sure?')); ?>">
                                            <span class="material-icons text-lg">delete</span>
                                            <span class="hidden sm:inline text-sm font-medium"><?php echo e(__('Delete')); ?></span>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="<?php echo e($colCount); ?>" class="px-5 py-16 text-center text-slate-500">
                            <?php echo e($emptyMessage); ?>

                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if($pagination && method_exists($pagination, 'links')): ?>
    <?php
        $perPageUrl = function ($n) {
            $q = request()->query();
            $q['per_page'] = $n;
            return request()->url() . '?' . http_build_query($q);
        };
    ?>
    <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
        <div class="inline-flex items-center gap-2">
            <select id="admin-per-page-<?php echo e(md5(request()->url())); ?>" onchange="window.location.href=this.value" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
                <?php $__currentLoopData = \admin_per_page_options(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($perPageUrl($n)); ?>" <?php echo e($pagination->perPage() == $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <label for="admin-per-page-<?php echo e(md5(request()->url())); ?>" class="text-sm text-slate-600"><?php echo e(__('Per page')); ?></label>
        </div>
        <div>
            <?php echo e($pagination->withQueryString()->links()); ?>

        </div>
    </div>
<?php endif; ?>

<?php if($hasBulk): ?>
</form>
<script>
(function() {
    var formId = 'bulk-form-<?php echo e(md5($bulk_form_action ?? '')); ?>';
    function runBulkScript() {
        var form = document.getElementById(formId);
        if (!form) return;
        var selectAll = form.querySelector('.bulk-select-all');
        var checkboxes = form.querySelectorAll('.bulk-row-checkbox');
        var countEl = form.querySelector('[data-bulk-count]');
        var applyBtn = form.querySelector('[data-bulk-apply]');
        function updateCount() {
            var n = form.querySelectorAll('.bulk-row-checkbox:checked').length;
            if (countEl) countEl.textContent = n ? (n + ' <?php echo e(__('selected')); ?>') : '<?php echo e(__('Select rows below, then choose an action.')); ?>';
            if (applyBtn) applyBtn.disabled = !n;
        }
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(function(cb) { cb.checked = selectAll.checked; });
                updateCount();
            });
        }
        checkboxes.forEach(function(cb) {
            cb.addEventListener('change', updateCount);
        });
        form.addEventListener('submit', function(e) {
            var checked = form.querySelectorAll('.bulk-row-checkbox:checked').length;
            if (!checked) {
                e.preventDefault();
                alert('<?php echo e(__("Please select at least one row.")); ?>');
                return false;
            }
            var actionSel = form.querySelector('select[name="action"]');
            if (actionSel && !actionSel.value) {
                e.preventDefault();
                alert('<?php echo e(__("Please select an action.")); ?>');
                return false;
            }
            if (actionSel && (actionSel.value === 'delete' || actionSel.value === 'bulk_delete')) {
                if (!confirm('<?php echo e(__("Are you sure you want to delete the selected records?")); ?>')) {
                    e.preventDefault();
                    return false;
                }
            }
        });
        updateCount();
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', runBulkScript);
    } else {
        runBulkScript();
    }
})();
</script>
<?php endif; ?>


<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\components\admin\table.blade.php ENDPATH**/ ?>