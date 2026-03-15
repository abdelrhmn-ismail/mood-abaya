@php
    $actionUrl = $actionUrl ?? null;
    $actionLabel = $actionLabel ?? __('Add');
    $actionIcon = $actionIcon ?? 'add';
@endphp
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>{{ $slot ?? '' }}</div>
    @if($actionUrl)
        <a href="{{ $actionUrl }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white hover:bg-brand-teal-dark">
            <span class="material-icons text-lg">{{ $actionIcon }}</span>
            {{ $actionLabel }}
        </a>
    @endif
</div>
