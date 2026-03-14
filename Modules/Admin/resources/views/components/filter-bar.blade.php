<form method="GET" class="mb-6 flex flex-wrap items-center gap-2">
    {{ $slot }}
    <button type="submit" class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300">
        {{ __('Filter') }}
    </button>
</form>
