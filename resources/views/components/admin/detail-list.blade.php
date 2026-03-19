@php
    $items = $items ?? [];
@endphp
<dl class="space-y-2">
    @foreach($items as $item)
        @php
            $label = $item['label'] ?? $item[0] ?? '';
            $value = $item['value'] ?? $item[1] ?? '';
            $raw = $item['raw'] ?? false;
        @endphp
        <div>
            <dt class="text-sm font-medium text-gray-500">{{ $label }}</dt>
            <dd class="mt-0.5 text-sm text-gray-900">
                @if($raw) {!! $value !!} @else {{ $value ?: '—' }} @endif
            </dd>
        </div>
    @endforeach
</dl>
