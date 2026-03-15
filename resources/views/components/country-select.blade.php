@props([
    'name' => 'country',
    'id' => null,
    'value' => '',
    'label' => __('Country'),
])
@php
    $id = $id ?? $name;
    $codes = config('phone_codes', []);
    $currentValue = $value ?: (old($name, 'Saudi Arabia'));
    $currentKey = 'SA';
    $currentName = 'Saudi Arabia';
    foreach ($codes as $key => $c) {
        $countryName = $c['country_name'] ?? $c['label'];
        if ((string) $countryName === (string) $currentValue) {
            $currentKey = $key;
            $currentName = $countryName;
            break;
        }
    }
    $countriesList = collect($codes)->map(fn ($c, $key) => [
        'iso' => strtolower($key),
        'value' => $c['country_name'] ?? $c['label'],
        'name' => $c['country_name'] ?? $c['label'],
    ])->values()->all();
@endphp
<div class="space-y-1" x-data="{
    open: false,
    iso: '{{ strtolower($currentKey) }}',
    selectedValue: {{ json_encode($currentName) }},
    countries: {{ json_encode($countriesList) }},
    choose(item) { this.iso = item.iso; this.selectedValue = item.value; this.open = false; }
}" x-id="['country-select']" @click.outside="open = false">
    <label for="{{ $id }}" class="mb-1 block text-sm font-medium text-slate-700">{{ $label }}</label>
    <div class="relative">
        <input type="hidden" name="{{ $name }}" id="{{ $id }}" :value="selectedValue">
        <button type="button"
                @click="open = !open"
                :aria-expanded="open"
                aria-haspopup="listbox"
                :aria-controls="$id('country-select')"
                class="flex w-full items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-left text-sm text-slate-900 transition focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/20"
                aria-label="{{ $label }}">
            <span class="fi shrink-0 rounded-sm shadow-sm" :class="'fi fi-' + iso" style="width: 1.25rem; height: 0.875rem; background-size: cover;"></span>
            <span class="min-w-0 flex-1 truncate" x-text="selectedValue">{{ $currentName }}</span>
            <span class="material-icons text-lg text-slate-400 transition" :class="open && 'rotate-180'">expand_more</span>
        </button>
        <div x-show="open"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             :id="$id('country-select')"
             role="listbox"
             class="absolute left-0 right-0 top-full z-50 mt-1 max-h-64 overflow-auto rounded-xl border border-slate-200 bg-white py-1 shadow-lg"
             x-cloak>
            <template x-for="item in countries" :key="item.value">
                <button type="button"
                        role="option"
                        :aria-selected="item.value === selectedValue"
                        @click="choose(item)"
                        class="flex w-full items-center gap-2 px-4 py-2.5 text-left text-sm text-slate-900 transition hover:bg-slate-50 focus:bg-slate-50 focus:outline-none"
                        :class="item.value === selectedValue ? 'bg-brand-teal/10 font-medium' : ''">
                    <span class="fi shrink-0 rounded-sm shadow-sm" :class="'fi fi-' + item.iso" style="width: 1.25rem; height: 0.875rem; background-size: cover;"></span>
                    <span class="min-w-0 flex-1 truncate" x-text="item.name"></span>
                </button>
            </template>
        </div>
    </div>
</div>
