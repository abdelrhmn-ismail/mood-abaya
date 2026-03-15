@props([
    'filters' => [],
    'preserveQueryKeys' => [],
])
@php
    $filters = $filters ?? [];
@endphp
<aside class="shrink-0 rounded-xl border border-slate-200 bg-white p-4 shadow-sm lg:w-64">
    <form method="GET" action="{{ request()->url() }}" class="space-y-4">
        @foreach($preserveQueryKeys as $key)
            @if(request($key) !== null && request($key) !== '')
                <input type="hidden" name="{{ $key }}" value="{{ request($key) }}">
            @endif
        @endforeach
        <div>
            <span class="text-sm font-medium text-slate-600">{{ __('Sort by') }}</span>
            <select name="sort" class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20" onchange="this.form.submit()">
                <option value="name_asc" {{ ($filters['sort'] ?? '') === 'name_asc' ? 'selected' : '' }}>{{ __('Name A–Z') }}</option>
                <option value="name_desc" {{ ($filters['sort'] ?? '') === 'name_desc' ? 'selected' : '' }}>{{ __('Name Z–A') }}</option>
                <option value="price_asc" {{ ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : '' }}>{{ __('Price: low to high') }}</option>
                <option value="price_desc" {{ ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' }}>{{ __('Price: high to low') }}</option>
                <option value="newest" {{ ($filters['sort'] ?? '') === 'newest' ? 'selected' : '' }}>{{ __('Newest') }}</option>
            </select>
        </div>
        <div>
            <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="in_stock" value="1" {{ ($filters['in_stock'] ?? false) ? 'checked' : '' }} onchange="this.form.submit()" class="rounded border-slate-300 text-brand-teal focus:ring-brand-teal">
                {{ __('In stock only') }}
            </label>
        </div>
        <div>
            <span class="text-sm font-medium text-slate-600">{{ __('Price range') }}</span>
            <div class="mt-1 flex items-center gap-2">
                <input type="number" name="price_min" step="0.01" min="0" placeholder="{{ __('Min') }}" value="{{ $filters['price_min'] ?? '' }}" class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-sm focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                <span class="text-slate-400">–</span>
                <input type="number" name="price_max" step="0.01" min="0" placeholder="{{ __('Max') }}" value="{{ $filters['price_max'] ?? '' }}" class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-sm focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
            </div>
        </div>
        <button type="submit" class="w-full rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-teal-dark">{{ __('Apply') }}</button>
    </form>
</aside>
