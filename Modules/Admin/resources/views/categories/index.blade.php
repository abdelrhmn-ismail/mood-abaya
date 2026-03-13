@extends('admin::layouts.app')

@section('title', __('Categories'))
@section('heading', __('Categories'))

@section('content')
<p class="mb-4"><a href="{{ route('admin.categories.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700">{{ __('Add category') }}</a></p>
<div class="overflow-x-auto rounded-lg bg-white shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Name') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Slug') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Sort') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Active') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($categories as $category)
                <tr>
                    <td class="px-4 py-2 text-sm">{{ $category->name }}</td>
                    <td class="px-4 py-2 font-mono text-sm">{{ $category->slug }}</td>
                    <td class="px-4 py-2 text-sm">{{ $category->sort_order }}</td>
                    <td class="px-4 py-2 text-sm">{{ $category->active ? __('Yes') : __('No') }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline ml-2" onsubmit="return confirm('{{ __('Delete this category?') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">{{ __('No categories yet.') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
