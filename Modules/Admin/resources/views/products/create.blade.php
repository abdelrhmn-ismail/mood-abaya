@extends('admin::layouts.app')

@section('title', __('Add product'))
@section('heading', __('Add product'))

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md space-y-4 rounded-lg bg-white p-6 shadow">
    @csrf
    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700">{{ __('Category') }} *</label>
        <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300" required>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }} *</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="slug" class="block text-sm font-medium text-gray-700">{{ __('Slug') }}</label>
        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="mt-1 block w-full rounded-md border-gray-300">
        @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300">{{ old('description') }}</textarea>
        @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700">{{ __('Price (SAR)') }} *</label>
        <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300" required>
        @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="image" class="block text-sm font-medium text-gray-700">{{ __('Image') }}</label>
        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm">
        @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="stock" class="block text-sm font-medium text-gray-700">{{ __('Stock') }}</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300">
        @error('stock')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }} class="rounded border-gray-300">
            <span class="ml-2 text-sm">{{ __('Active') }}</span>
        </label>
    </div>
    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700">{{ __('Create product') }}</button>
    <a href="{{ route('admin.products.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</a>
</form>
@endsection
