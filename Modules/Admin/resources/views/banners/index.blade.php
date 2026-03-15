@extends('admin::layouts.app')

@section('title', __('Banners'))
@section('heading', __('Banners'))

@section('content')
@component('admin::components.card', ['title' => null])
    <p class="mb-4 text-sm text-gray-600">{{ __('Promo banners shown below the navbar or above the footer. Set dates to show only within a range.') }}</p>
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <span class="text-sm text-gray-500">{{ $banners->total() }} {{ __('items') }}</span>
        <a href="{{ route('admin.banners.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-teal-dark">
            <span class="material-icons text-lg">add</span> {{ __('Add banner') }}
        </a>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-50/80">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        <a href="{{ admin_sort_url('title') }}" class="inline-flex items-center gap-1 transition hover:text-brand-teal">
                            {{ __('Title') }}
                            @if(request('sort') === 'title')
                                <span class="material-icons text-base">{{ request('order', 'asc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}</span>
                            @else
                                <span class="material-icons text-base opacity-50">unfold_more</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        <a href="{{ admin_sort_url('start_at') }}" class="inline-flex items-center gap-1 transition hover:text-brand-teal">
                            {{ __('Period') }}
                            @if(request('sort') === 'start_at' || !request('sort'))
                                <span class="material-icons text-base">{{ request('order', 'asc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}</span>
                            @else
                                <span class="material-icons text-base opacity-50">unfold_more</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        <a href="{{ admin_sort_url('active') }}" class="inline-flex items-center gap-1 transition hover:text-brand-teal">
                            {{ __('Status') }}
                            @if(request('sort') === 'active')
                                <span class="material-icons text-base">{{ request('order', 'asc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}</span>
                            @else
                                <span class="material-icons text-base opacity-50">unfold_more</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($banners as $banner)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3">
                            <span class="font-medium text-gray-900">{{ Str::limit($banner->title, 60) }}</span>
                            @if($banner->link)
                                <span class="ml-2 text-xs text-gray-500">→ {{ Str::limit($banner->link, 30) }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $banner->start_at?->format('Y-m-d') ?? '—' }} … {{ $banner->end_at?->format('Y-m-d') ?? '—' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($banner->active)
                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">{{ __('Active') }}</span>
                            @else
                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">{{ __('Inactive') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-brand-teal transition hover:bg-brand-gold/10">{{ __('Edit') }}</a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('Are you sure you want to delete this banner?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">{{ __('No banners yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($banners->hasPages())
        <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
            <form method="GET" action="{{ request()->url() }}" class="flex items-center gap-2">
                @foreach(request()->query() as $key => $value)
                    @if($key !== 'per_page')
                        @if(is_array($value))
                            @foreach($value as $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endif
                @endforeach
                <label for="admin-per-page-banners" class="text-sm text-slate-600">{{ __('Per page') }}</label>
                <select name="per_page" id="admin-per-page-banners" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
                    @foreach(admin_per_page_options() as $n)
                        <option value="{{ $n }}" {{ $banners->perPage() == $n ? 'selected' : '' }}>{{ $n }}</option>
                    @endforeach
                </select>
            </form>
            <div>{{ $banners->withQueryString()->links() }}</div>
        </div>
    @endif
@endcomponent
@endsection
