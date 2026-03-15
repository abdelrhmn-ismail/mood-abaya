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
    $currentNumber = $value;
    if ($value && (str_starts_with((string)$value, '+') || preg_match('/^\d+/', (string)$value))) {
        foreach ($codeKeys as $key) {
            $c = $codes[$key]['code'];
            if (str_starts_with((string)$value, $c)) {
                $currentCode = $c;
                $currentNumber = trim(substr((string)$value, strlen($c)), ' -');
                break;
            }
        }
        if (!str_starts_with((string)$value, '+') && $currentNumber === $value) {
            $currentNumber = preg_replace('/^0+/', '', (string)$value);
        }
    }
    $currentFlag = '🇸🇦';
    $currentCountryName = 'Saudi Arabia';
    foreach ($codes as $c) {
        if (($c['code'] ?? '') === $currentCode) {
            $currentFlag = $c['flag'] ?? '🇸🇦';
            $currentCountryName = $c['country_name'] ?? $currentCode;
            break;
        }
    }
    $codeName = $name . '_country_code';
    $numberName = $name . '_number';
@endphp
<div class="space-y-1">
    <label for="{{ $id }}_number" class="block text-sm font-medium text-slate-700">
        {{ $label }} <span class="font-normal text-slate-500">({{ $currentFlag }} {{ $currentCountryName }} {{ $currentCode }})</span>
        @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <div class="flex gap-2">
        <select name="{{ $codeName }}" id="{{ $id }}_code" class="min-w-[12rem] shrink-0 rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20" aria-label="{{ __('Country code') }}">
            @foreach($codes as $key => $c)
                <option value="{{ $c['code'] }}" {{ $currentCode === $c['code'] ? 'selected' : '' }}>{{ $c['flag'] }} {{ $c['country_name'] ?? $c['label'] }} {{ $c['code'] }}</option>
            @endforeach
        </select>
        <input type="tel"
               name="{{ $numberName }}"
               id="{{ $id }}_number"
               value="{{ $currentNumber }}"
               {{ $required ? 'required' : '' }}
               placeholder="5xxxxxxxx"
               class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20 {{ $inputClass }}"
               {{ $attributes->except(['class', 'inputClass'])->merge([]) }}>
    </div>
    @error($codeName)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    @error($numberName)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>
