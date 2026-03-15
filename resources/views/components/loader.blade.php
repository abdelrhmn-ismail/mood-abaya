@props([
    'show' => true,
    'label' => null,
    'fixed' => false,
])

@if($show)
<div
    {{ $attributes->merge([
        'class' => ($fixed ? 'fixed' : 'absolute') . ' inset-0 z-[100] flex items-center justify-center bg-white/70',
        'role' => 'status',
        'aria-label' => $label ?? __('Loading'),
    ]) }}
>
    <div class="flex flex-col items-center gap-3">
        <span
            class="inline-block h-8 w-8 animate-spin rounded-full border-2 border-slate-300 border-t-brand-teal"
            aria-hidden="true"
        ></span>
        @if($label)
            <span class="text-sm font-medium text-slate-600">{{ $label }}</span>
        @endif
    </div>
</div>
@endif
