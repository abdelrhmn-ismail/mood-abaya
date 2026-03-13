@php
    $columns = $columns ?? [];
    $rows = $rows ?? collect();
    $emptyMessage = $emptyMessage ?? __('No records found.');
    $actions = $actions ?? [];
    $pagination = $pagination ?? null;
    $rowHighlightKey = $rowHighlightKey ?? null;   // e.g. 'read_at' – when empty, row gets highlighted
    $rowHighlightClass = $rowHighlightClass ?? 'bg-blue-50/50';
    $hasActions = !empty($actions) && (!empty($actions['view_route']) || !empty($actions['edit_route']) || !empty($actions['delete_route']));
    $colCount = count($columns) + ($hasActions ? 1 : 0);

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
        if ($val === null || $val === '') {
            return '—';
        }
        return $val;
    };
@endphp

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @foreach($columns as $col)
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            {{ $col['label'] ?? '' }}
                        </th>
                    @endforeach
                    @if($hasActions)
                        <th scope="col" class="relative px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                            {{ __('Actions') }}
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($rows as $row)
                    @php
                        $rowClass = 'hover:bg-gray-50 transition-colors';
                        if ($rowHighlightKey !== null && empty(data_get($row, $rowHighlightKey))) {
                            $rowClass .= ' ' . $rowHighlightClass;
                        }
                    @endphp
                    <tr class="{{ $rowClass }}">
                        @foreach($columns as $col)
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-900 {{ $col['class'] ?? '' }}">
                                {{ $getCellValue($row, $col) }}
                            </td>
                        @endforeach
                        @if($hasActions)
                            <td class="relative whitespace-nowrap px-4 py-3 text-right text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    @if(!empty($actions['view_route']))
                                        <a href="{{ route($actions['view_route'], $row) }}" class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-gray-600 hover:bg-gray-100 hover:text-gray-900" title="{{ __('View') }}">
                                            <span class="material-icons text-lg">visibility</span>
                                            <span class="hidden sm:inline">{{ __('View') }}</span>
                                        </a>
                                    @endif
                                    @if(!empty($actions['edit_route']))
                                        <a href="{{ route($actions['edit_route'], $row) }}" class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-indigo-600 hover:bg-indigo-50" title="{{ __('Edit') }}">
                                            <span class="material-icons text-lg">edit</span>
                                            <span class="hidden sm:inline">{{ __('Edit') }}</span>
                                        </a>
                                    @endif
                                    @if(!empty($actions['delete_route']))
                                        <form action="{{ route($actions['delete_route'], $row) }}" method="POST" class="inline" onsubmit="return confirm('{{ $actions['delete_confirm'] ?? __('Are you sure?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-red-600 hover:bg-red-50" title="{{ __('Delete') }}">
                                                <span class="material-icons text-lg">delete</span>
                                                <span class="hidden sm:inline">{{ __('Delete') }}</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $colCount }}" class="px-4 py-12 text-center text-gray-500">
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
