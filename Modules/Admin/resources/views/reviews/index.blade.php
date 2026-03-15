@extends('admin::layouts.app')

@section('title', __('Reviews'))
@section('heading', __('Reviews'))

@section('content')
@component('admin::components.card', ['title' => null])
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
    @endif
    <p class="mb-4 text-sm text-gray-500">{{ __('Product reviews from completed orders. Hide a review to prevent it from showing on the product page.') }}</p>

    @component('admin::components.filter-bar')
        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search comment') }}" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <select name="rating" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
            <option value="">{{ __('All ratings') }}</option>
            @for($r = 1; $r <= 5; $r++)
                <option value="{{ $r }}" {{ request('rating') === (string)$r ? 'selected' : '' }}>{{ $r }} ★</option>
            @endfor
        </select>
        <select name="visible" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
            <option value="">{{ __('All visibility') }}</option>
            <option value="1" {{ request('visible') === '1' ? 'selected' : '' }}>{{ __('Visible') }}</option>
            <option value="0" {{ request('visible') === '0' ? 'selected' : '' }}>{{ __('Hidden') }}</option>
        </select>
        <select name="product_id" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
            <option value="">{{ __('All products') }}</option>
            @foreach($products ?? [] as $p)
                <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
            @endforeach
        </select>
    @endcomponent

    <form method="POST" action="{{ route('admin.reviews.bulk') }}" id="reviews-bulk-form">
        @csrf
        <div class="mb-3 flex flex-wrap items-center gap-3 rounded-lg border border-gray-200 bg-slate-50/50 px-4 py-2">
            <span class="text-sm text-slate-600" data-bulk-count>{{ __('Select rows below, then choose an action.') }}</span>
            <select name="action" required class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
                <option value="">{{ __('Bulk action') }}</option>
                <option value="show">{{ __('Show') }}</option>
                <option value="hide">{{ __('Hide') }}</option>
                <option value="delete">{{ __('Delete') }}</option>
            </select>
            <button type="submit" class="rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white hover:bg-brand-teal-dark" data-bulk-apply>{{ __('Apply') }}</button>
        </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-slate-50/80">
                    <th class="w-10 px-3 py-3">
                        <input type="checkbox" class="reviews-select-all rounded border-gray-300 text-brand-teal focus:ring-brand-teal" aria-label="{{ __('Select all') }}">
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">{{ __('Product') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">{{ __('User') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">{{ __('Order') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        <a href="{{ admin_sort_url('rating') }}" class="inline-flex items-center gap-1 transition hover:text-brand-teal">
                            {{ __('Rating') }}
                            @if(request('sort') === 'rating')
                                <span class="material-icons text-base">{{ request('order', 'desc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}</span>
                            @else
                                <span class="material-icons text-base opacity-50">unfold_more</span>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">{{ __('Comment') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        <a href="{{ admin_sort_url('is_visible') }}" class="inline-flex items-center gap-1 transition hover:text-brand-teal">
                            {{ __('Visible') }}
                            @if(request('sort') === 'is_visible')
                                <span class="material-icons text-base">{{ request('order', 'desc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}</span>
                            @else
                                <span class="material-icons text-base opacity-50">unfold_more</span>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-gray-600">
                        <a href="{{ admin_sort_url('created_at') }}" class="inline-flex items-center gap-1 transition hover:text-brand-teal ml-auto">
                            {{ __('Date') }}
                            @if(request('sort') === 'created_at' || !request('sort'))
                                <span class="material-icons text-base">{{ request('order', 'desc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}</span>
                            @else
                                <span class="material-icons text-base opacity-50">unfold_more</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase text-gray-600">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($reviews as $review)
                    <tr class="hover:bg-slate-50/50">
                        <td class="w-10 px-3 py-3">
                            <input type="checkbox" name="ids[]" value="{{ $review->id }}" class="reviews-row-cb rounded border-gray-300 text-brand-teal focus:ring-brand-teal">
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <a href="{{ route('admin.products.edit', $review->product) }}" class="font-medium text-brand-teal hover:underline">{{ $review->product?->name ?? '—' }}</a>
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
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $review->created_at?->format('Y-m-d H:i') ?? '—' }}</td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" class="rounded-lg px-3 py-2 text-sm font-medium admin-review-toggle {{ $review->is_visible ? 'text-amber-600 hover:bg-amber-50' : 'text-green-600 hover:bg-green-50' }}" data-url="{{ route('admin.reviews.toggle-visibility', $review) }}">
                                {{ $review->is_visible ? __('Hide') : __('Show') }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center text-gray-500">{{ __('No reviews yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </form>
    <script>
    (function() {
        function run() {
            var form = document.getElementById('reviews-bulk-form');
            if (!form) return;
            var selectAll = form.querySelector('.reviews-select-all');
            var checkboxes = form.querySelectorAll('.reviews-row-cb');
            var countEl = form.querySelector('[data-bulk-count]');
            var applyBtn = form.querySelector('[data-bulk-apply]');
            function updateCount() {
                var n = form.querySelectorAll('.reviews-row-cb:checked').length;
                if (countEl) countEl.textContent = n ? (n + ' {{ __('selected') }}') : '{{ __('Select rows below, then choose an action.') }}';
                if (applyBtn) applyBtn.disabled = !n;
            }
            if (selectAll) selectAll.addEventListener('change', function() {
                checkboxes.forEach(function(cb) { cb.checked = selectAll.checked; });
                updateCount();
            });
            checkboxes.forEach(function(cb) { cb.addEventListener('change', updateCount); });
            form.addEventListener('submit', function(e) {
                if (!form.querySelector('.reviews-row-cb:checked').length) {
                    e.preventDefault();
                    alert('{{ __("Please select at least one row.") }}');
                    return false;
                }
                if (form.querySelector('select[name="action"]').value === 'delete' && !confirm('{{ __("Are you sure you want to delete the selected records?") }}')) {
                    e.preventDefault();
                    return false;
                }
            });
            updateCount();
        }
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', run);
        else run();
    })();
    (function() {
        if (window.__adminReviewToggleBound) return;
        window.__adminReviewToggleBound = true;
        document.body.addEventListener('click', function(e) {
            var btn = e.target.closest('.admin-review-toggle');
            if (!btn) return;
            e.preventDefault();
            var url = btn.getAttribute('data-url');
            if (!url) return;
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            var csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            var meta = document.querySelector('meta[name="csrf-token"]');
            csrf.value = meta ? meta.getAttribute('content') : '';
            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
        });
    })();
    </script>
    @if($reviews->hasPages())
        <div class="mt-4">{{ $reviews->withQueryString()->links() }}</div>
    @endif
@endcomponent
@endsection
