@php
    $name = $name ?? '';
    $id = $id ?? str_replace(['[', ']'], '_', $name);
    $oldKey = preg_replace('/\[(\w+)\]/', '.$1', $name);
    $label = $label ?? '';
    $value = $value ?? '';
    $required = $required ?? false;
    $attributes = $attributes ?? [];
    $errorKey = $errorKey ?? $name;
    $inputClass = 'mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm min-h-[200px] ';
@endphp
<div class="rich-editor-wrap" data-rich-editor>
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
            {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif
    <textarea name="{{ $name }}" id="{{ $id }}" class="{{ $inputClass }} rich-editor"
              @if($required) required @endif
              @foreach($attributes as $k => $v) @if(!in_array($k, ['rows'])) {{ $k }}="{{ $v }}" @endif @endforeach
    >{!! old($oldKey, $value) !!}</textarea>
    @error($errorKey)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
