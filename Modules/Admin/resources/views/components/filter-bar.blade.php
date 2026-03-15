<form method="GET" class="mb-6 flex flex-wrap items-center gap-2">
    <input type="hidden" name="per_page" value="{{ request('per_page', admin_per_page_default()) }}">
    @if(request()->has('sort'))
        <input type="hidden" name="sort" value="{{ request('sort') }}">
        <input type="hidden" name="order" value="{{ request('order', 'asc') }}">
    @endif
    {{ $slot }}
    <button type="submit" class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300">
        {{ __('Filter') }}
    </button>
</form>
