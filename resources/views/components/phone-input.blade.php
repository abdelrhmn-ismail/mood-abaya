@props([
    'name' => 'phone',
    'id' => null,
    'value' => '',
    'required' => false,
    'label' => __('Phone'),
    'inputClass' => '',
])
@php
    $id = $id ?? $name;
    $codes = config('phone_codes', []);
    $codeKeys = array_keys($codes);
    usort($codeKeys, fn ($a, $b) => strlen($codes[$b]['code']) <=> strlen($codes[$a]['code']));
    $currentCode = '+966';
    $currentKey = 'SA';
    $currentLabel = 'SA';
    $currentNumber = $value;
    if ($value && (str_starts_with((string)$value, '+') || preg_match('/^\d+/', (string)$value))) {
        foreach ($codeKeys as $key) {
            $c = $codes[$key]['code'];
            if (str_starts_with((string)$value, $c)) {
                $currentCode = $c;
                $currentKey = $key;
                $currentLabel = $codes[$key]['label'] ?? $key;
                $currentNumber = trim(substr((string)$value, strlen($c)), ' -');
                break;
            }
        }
        if (!str_starts_with((string)$value, '+') && $currentNumber === $value) {
            $currentNumber = preg_replace('/^0+/', '', (string)$value);
        }
    }
    $currentLabel = $currentLabel ?? ($codes[$currentKey]['label'] ?? $currentKey);
    $codeName = $name . '_country_code';
    $numberName = $name . '_number';
    $codesList = collect($codes)->map(fn ($c, $key) => ['iso' => strtolower($key), 'code' => $c['code'], 'label' => $c['label'] ?? $key])->values()->all();
@endphp
<div class="space-y-1" x-data="{
    open: false,
    iso: '{{ strtolower($currentKey) }}',
    selectedCode: '{{ $currentCode }}',
    selectedLabel: '{{ $currentLabel }}',
    codes: {{ json_encode($codesList) }},
    choose(item) { this.iso = item.iso; this.selectedCode = item.code; this.selectedLabel = item.label; this.open = false; }
}" x-id="['phone-code']" @click.outside="open = false">
    <label for="{{ $id }}_number" class="block text-sm font-medium text-slate-700">
        {{ $label }}
        @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <div class="flex gap-2">
        <div class="relative min-w-[10rem] shrink-0">
            <input type="hidden" name="{{ $codeName }}" id="{{ $id }}_code" :value="selectedCode">
            <button type="button"
                    @click="open = !open"
                    :aria-expanded="open"
                    :aria-haspopup="true"
                    :aria-controls="$id('phone-code')"
                    class="flex w-full items-center gap-2 rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-left text-sm text-slate-900 transition focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/20"
                    aria-label="{{ __('Country code') }}">
                <span class="fi shrink-0 rounded-sm shadow-sm" :class="'fi fi-' + iso" style="width: 1.25rem; height: 0.875rem; background-size: cover;"></span>
                <span class="min-w-0 flex-1 truncate" x-text="selectedLabel + ' ' + selectedCode">{{ $currentLabel }} {{ $currentCode }}</span>
                <span class="material-icons text-lg text-slate-400 transition" :class="open && 'rotate-180'">expand_more</span>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 :id="$id('phone-code')"
                 role="listbox"
                 class="absolute left-0 right-0 top-full z-50 mt-1 max-h-64 overflow-auto rounded-xl border border-slate-200 bg-white py-1 shadow-lg"
                 x-cloak>
                <template x-for="item in codes" :key="item.code">
                    <button type="button"
                            role="option"
                            :aria-selected="item.code === selectedCode"
                            @click="choose(item)"
                            class="flex w-full items-center gap-2 px-3 py-2.5 text-left text-sm text-slate-900 transition hover:bg-slate-50 focus:bg-slate-50 focus:outline-none"
                            :class="item.code === selectedCode ? 'bg-brand-teal/10 font-medium' : ''">
                        <span class="fi shrink-0 rounded-sm shadow-sm" :class="'fi fi-' + item.iso" style="width: 1.25rem; height: 0.875rem; background-size: cover;"></span>
                        <span class="min-w-0 flex-1 truncate" x-text="item.label + ' ' + item.code"></span>
                    </button>
                </template>
            </div>
        </div>
        <input type="tel"
               name="{{ $numberName }}"
               id="{{ $id }}_number"
               value="{{ $currentNumber }}"
               {{ $required ? 'required' : '' }}
               placeholder="{{ __('Phone number example') }}"
               class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20 {{ $inputClass }}"
               {{ $attributes->except(['class', 'inputClass'])->merge([]) }}>
    </div>
    @error($codeName)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    @error($numberName)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>
