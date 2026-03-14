@extends('admin::layouts.app')

@section('title', __('Reviews'))
@section('heading', __('Reviews'))

@section('content')
@component('admin::components.card', ['title' => null])
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
    @endif
    <p class="mb-4 text-sm text-gray-500">{{ __('Product reviews from completed orders. Hide a review to prevent it from showing on the product page.') }}</p>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-slate-50/80">
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">{{ __('Product') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">{{ __('User') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">{{ __('Order') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">{{ __('Rating') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">{{ __('Comment') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">{{ __('Visible') }}</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-gray-600">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($reviews as $review)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <a href="{{ route('admin.products.edit', $review->product) }}" class="font-medium text-indigo-600 hover:underline">{{ $review->product?->name ?? '—' }}</a>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $review->user?->name ?? '—' }}</td>
                        <td class="px-4 py-3 font-mono text-sm text-gray-700">{{ $review->order?->order_number ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm">
                            @for($s = 1; $s <= 5; $s++)
                                <span class="text-amber-500">{{ $s <= $review->rating ? '★' : '☆' }}</span>
                            @endfor
                        </td>
                        <td class="max-w-xs px-4 py-3 text-sm text-gray-600 truncate" title="{{ $review->comment }}">{{ Str::limit($review->comment, 50) ?: '—' }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($review->is_visible)
                                <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">{{ __('Yes') }}</span>
                            @else
                                <span class="rounded-full bg-gray-200 px-2 py-0.5 text-xs font-medium text-gray-600">{{ __('Hidden') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <form action="{{ route('admin.reviews.toggle-visibility', $review) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="rounded-lg px-3 py-2 text-sm font-medium {{ $review->is_visible ? 'text-amber-600 hover:bg-amber-50' : 'text-green-600 hover:bg-green-50' }}">
                                    {{ $review->is_visible ? __('Hide') : __('Show') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-gray-500">{{ __('No reviews yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reviews->hasPages())
        <div class="mt-4">{{ $reviews->withQueryString()->links() }}</div>
    @endif
@endcomponent
@endsection
