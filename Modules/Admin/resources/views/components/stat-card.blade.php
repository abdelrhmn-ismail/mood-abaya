@php
    $label = $label ?? '';
    $value = $value ?? '0';
    $url = $url ?? null;
@endphp
<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="p-6">
        <h3 class="text-sm font-medium text-gray-500">{{ $label }}</h3>
        @if($url)
            <a href="{{ $url }}" class="mt-2 block text-3xl font-semibold text-gray-900 hover:text-indigo-600">{{ $value }}</a>
        @else
            <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $value }}</p>
        @endif
    </div>
</div>
