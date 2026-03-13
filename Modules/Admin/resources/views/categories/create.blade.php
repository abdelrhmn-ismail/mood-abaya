@extends('admin::layouts.app')

@section('title', __('Add category'))
@section('heading', __('Add category'))

@section('content')
<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md space-y-4 rounded-lg bg-white p-6 shadow">
    @csrf
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
        <label for="image" class="block text-sm font-medium text-gray-700">{{ __('Image') }}</label>
        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm">
        @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700">{{ __('Sort order') }}</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" class="mt-1 block w-full rounded-md border-gray-300">
        @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }} class="rounded border-gray-300">
            <span class="ml-2 text-sm">{{ __('Active') }}</span>
        </label>
    </div>
    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700">{{ __('Create category') }}</button>
    <a href="{{ route('admin.categories.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</a>
</form>
@endsection
