@extends('admin::layouts.app')

@section('title', __('Page content'))
@section('heading', __('Page content'))

@section('content')
@component('admin::components.card', ['title' => null])
    <p class="mb-4 text-sm text-gray-600">{{ __('Edit static pages: Terms, Privacy, Shipping, Return & Refund.') }}</p>
    @component('admin::components.filter-bar')
        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search page name or slug') }}" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
    @endcomponent
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-50/80">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Page') }}</th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($pages as $page)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3">
                            <span class="font-medium text-gray-900">{{ $page->page_name }}</span>
                            <span class="ml-2 font-mono text-xs text-gray-500">/page/{{ $page->page_slug }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.page-contents.edit', $page) }}" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-brand-teal transition hover:bg-brand-gold/10">{{ __('Edit') }}</a>
                            <a href="{{ route('page.show', $page->page_slug) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100">{{ __('View') }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endcomponent
@endsection
