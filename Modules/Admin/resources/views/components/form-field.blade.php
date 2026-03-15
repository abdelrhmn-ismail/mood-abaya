@php
    $name = $name ?? '';
    $id = $id ?? str_replace(['[', ']'], '_', $name);
    $oldKey = preg_replace('/\[(\w+)\]/', '.$1', $name);
    $label = $label ?? '';
    $type = $type ?? 'text';
    $value = $value ?? '';
    $required = $required ?? false;
    $options = $options ?? []; // for select: [['value' => 'x', 'label' => 'y'], ...]
    $attributes = $attributes ?? []; // placeholder, step, min, max, rows, accept, etc.
    $errorKey = $errorKey ?? $name;
    $inputClass = 'mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-teal focus:ring-brand-teal text-sm ';
@endphp
<div>
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
            {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif
    @if($type === 'select')
        <select name="{{ $name }}" id="{{ $id }}" class="{{ $inputClass }}"
                @if($required) required @endif
                @foreach($attributes as $k => $v) {{ $k }}="{{ $v }}" @endforeach
        >
            @foreach($options as $opt)
                <option value="{{ $opt['value'] ?? $opt[0] }}" {{ (string)($value ?? '') === (string)($opt['value'] ?? $opt[0]) ? 'selected' : '' }}>
                    {{ $opt['label'] ?? $opt[1] ?? $opt['value'] ?? $opt[0] }}
                </option>
            @endforeach
        </select>
    @elseif($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $id }}" rows="{{ $attributes['rows'] ?? 3 }}" class="{{ $inputClass }}"
                  @if($required) required @endif
                  @foreach($attributes as $k => $v) @if($k !== 'rows') {{ $k }}="{{ $v }}" @endif @endforeach
        >{{ old($oldKey, $value) }}</textarea>
    @elseif($type === 'checkbox')
        <label class="mt-2 inline-flex items-center">
            <input type="checkbox" name="{{ $name }}" value="1" {{ old($oldKey, $value) ? 'checked' : '' }} class="rounded border-gray-300 text-brand-teal focus:ring-brand-teal">
            <span class="ml-2 text-sm text-gray-700">{{ $attributes['help'] ?? '' }}</span>
        </label>
    @elseif($type === 'file')
        @if(!empty($attributes['current']))
            <p class="mb-1 text-sm text-gray-500">{{ __('Current') }}: <a href="{{ $attributes['current_url'] ?? '#' }}" target="_blank" class="text-brand-teal">{{ $attributes['current'] }}</a></p>
        @endif
        <input type="file" name="{{ $name }}" id="{{ $id }}" accept="{{ $attributes['accept'] ?? 'image/*' }}" class="{{ $inputClass }} text-sm">
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ old($oldKey, $value) }}"
               class="{{ $inputClass }}"
               @if($required) required @endif
               @foreach($attributes as $k => $v) {{ $k }}="{{ $v }}" @endforeach
        >
    @endif
    @error($errorKey)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
