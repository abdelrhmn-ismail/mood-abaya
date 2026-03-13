@extends('admin::layouts.app')

@section('title', __('Products'))
@section('heading', __('Products'))

@section('content')
<p class="mb-4"><a href="{{ route('admin.products.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700">{{ __('Add product') }}</a></p>
<form method="GET" class="mb-4 flex flex-wrap gap-2">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search') }}" class="rounded-md border-gray-300 text-sm">
    <select name="category_id" class="rounded-md border-gray-300 text-sm">
        <option value="">{{ __('All categories') }}</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="rounded-md bg-gray-200 px-3 py-1 text-sm hover:bg-gray-300">{{ __('Filter') }}</button>
</form>
<div class="overflow-x-auto rounded-lg bg-white shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Name') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Category') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Price') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Stock') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Active') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($products as $product)
                <tr>
                    <td class="px-4 py-2 text-sm">{{ $product->name }}</td>
                    <td class="px-4 py-2 text-sm">{{ $product->category?->name ?? '-' }}</td>
                    <td class="px-4 py-2 text-sm">{{ number_format($product->price, 2) }} SAR</td>
                    <td class="px-4 py-2 text-sm">{{ $product->stock }}</td>
                    <td class="px-4 py-2 text-sm">{{ $product->active ? __('Yes') : __('No') }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline ml-2" onsubmit="return confirm('{{ __('Delete this product?') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">{{ __('No products yet.') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $products->withQueryString()->links() }}</div>
@endsection
