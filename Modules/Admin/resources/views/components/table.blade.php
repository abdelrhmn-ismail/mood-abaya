@php
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

        $val = $key !== null ? data_get($row, $key) : '';
        if ($key2 !== null) {
            $val2 = data_get($row, $key2);
            $val = $val . $glue . $val2;
        }

        if ($format === 'datetime' && $val && is_object($val) && method_exists($val, 'format')) {
            return $val->format('Y-m-d H:i');
        }
        if ($format === 'price' && $val !== null && $val !== '') {
            return number_format((float) $val, 2) . ' SAR';
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
@endphp

@if($hasBulk)
<form method="POST" action="{{ $bulk_form_action }}" id="bulk-form-{{ md5($bulk_form_action ?? '') }}" class="bulk-form">
    @csrf
    <div class="flex flex-wrap items-center gap-3 border-b border-gray-200 bg-slate-50/50 px-5 py-3">
        <span class="text-sm text-slate-600" data-bulk-count>{{ __('Select rows below, then choose an action.') }}</span>
        <select name="action" required class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">{{ __('Bulk action') }}</option>
            @foreach($bulk_actions as $opt)
                <option value="{{ $opt['value'] ?? $opt[0] }}">{{ $opt['label'] ?? $opt[1] ?? $opt['value'] ?? $opt[0] }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700" data-bulk-apply>{{ __('Apply') }}</button>
    </div>
@endif
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-slate-50/80">
                    @if($hasBulk)
                        <th scope="col" class="w-10 px-3 py-4">
                            <input type="checkbox" class="bulk-select-all rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" aria-label="{{ __('Select all') }}">
                        </th>
                    @endif
                    @foreach($columns as $col)
                        <th scope="col" class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">
                            {{ $col['label'] ?? '' }}
                        </th>
                    @endforeach
                    @if($hasActions)
                        <th scope="col" class="relative px-5 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">
                            {{ __('Actions') }}
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($rows as $row)
                    @php
                        $rowClass = 'bg-white transition-colors hover:bg-slate-50/70';
                        if ($rowHighlightKey !== null && empty(data_get($row, $rowHighlightKey))) {
                            $rowClass .= ' ' . $rowHighlightClass;
                        }
                    @endphp
                    <tr class="{{ $rowClass }}">
                        @if($hasBulk)
                            <td class="w-10 px-3 py-4">
                                <input type="checkbox" name="ids[]" value="{{ data_get($row, $row_key) }}" class="bulk-row-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </td>
                        @endif
                        @foreach($columns as $col)
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-800 {{ $col['class'] ?? '' }}">
                                {{ $getCellValue($row, $col) }}
                            </td>
                        @endforeach
                        @if($hasActions)
                            <td class="relative whitespace-nowrap px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    @if(!empty($actions['view_route']))
                                        <a href="{{ route($actions['view_route'], $row) }}" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900" title="{{ __('View') }}">
                                            <span class="material-icons text-lg">visibility</span>
                                            <span class="hidden sm:inline text-sm font-medium">{{ __('View') }}</span>
                                        </a>
                                    @endif
                                    @if(!empty($actions['edit_route']))
                                        <a href="{{ route($actions['edit_route'], $row) }}" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-indigo-600 transition hover:bg-indigo-50" title="{{ __('Edit') }}">
                                            <span class="material-icons text-lg">edit</span>
                                            <span class="hidden sm:inline text-sm font-medium">{{ __('Edit') }}</span>
                                        </a>
                                    @endif
                                    @if(!empty($actions['delete_route']))
                                        <button type="button" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-red-600 transition hover:bg-red-50 admin-delete-one" title="{{ __('Delete') }}" data-delete-url="{{ route($actions['delete_route'], $row) }}" data-delete-confirm="{{ $actions['delete_confirm'] ?? __('Are you sure?') }}">
                                            <span class="material-icons text-lg">delete</span>
                                            <span class="hidden sm:inline text-sm font-medium">{{ __('Delete') }}</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $colCount }}" class="px-5 py-16 text-center text-slate-500">
                            {{ $emptyMessage }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($pagination && method_exists($pagination, 'links'))
    <div class="mt-4">
        {{ $pagination->withQueryString()->links() }}
    </div>
@endif

@if($hasBulk)
</form>
<script>
(function() {
    var formId = 'bulk-form-{{ md5($bulk_form_action ?? '') }}';
    function runBulkScript() {
        var form = document.getElementById(formId);
        if (!form) return;
        var selectAll = form.querySelector('.bulk-select-all');
        var checkboxes = form.querySelectorAll('.bulk-row-checkbox');
        var countEl = form.querySelector('[data-bulk-count]');
        var applyBtn = form.querySelector('[data-bulk-apply]');
        function updateCount() {
            var n = form.querySelectorAll('.bulk-row-checkbox:checked').length;
            if (countEl) countEl.textContent = n ? (n + ' {{ __('selected') }}') : '{{ __('Select rows below, then choose an action.') }}';
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
                alert('{{ __("Please select at least one row.") }}');
                return false;
            }
            var actionSel = form.querySelector('select[name="action"]');
            if (actionSel && !actionSel.value) {
                e.preventDefault();
                alert('{{ __("Please select an action.") }}');
                return false;
            }
            if (actionSel && (actionSel.value === 'delete' || actionSel.value === 'bulk_delete')) {
                if (!confirm('{{ __("Are you sure you want to delete the selected records?") }}')) {
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
@endif

{{-- Single-row delete: no nested form, so bulk form stays valid --}}
<script>
(function() {
    if (window.__adminDeleteBound) return;
    window.__adminDeleteBound = true;
    document.body.addEventListener('click', function(e) {
        var btn = e.target.closest('.admin-delete-one');
        if (!btn) return;
        e.preventDefault();
        var url = btn.getAttribute('data-delete-url');
        var msg = btn.getAttribute('data-delete-confirm') || '{{ __("Are you sure?") }}';
        if (!url) return;
        if (!confirm(msg)) return;
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        var csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        var meta = document.querySelector('meta[name="csrf-token"]');
        csrf.value = meta ? meta.getAttribute('content') : '';
        form.appendChild(csrf);
        var method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    });
})();
</script>
