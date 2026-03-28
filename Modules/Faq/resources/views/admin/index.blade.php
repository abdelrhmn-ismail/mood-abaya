@extends('admin.layouts.app')

@section('title', __('FAQ'))
@section('heading', __('FAQ'))

@section('content')
@component('components.admin.card', ['title' => null])
    <p class="mb-4 text-sm text-gray-600">{{ __('Manage questions and answers shown on the Contact page.') }}</p>
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <span class="text-sm text-gray-500">{{ $faqs->count() }} {{ __('items') }}</span>
        <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-teal-dark">
            <span class="material-icons text-lg">add</span> {{ __('Add FAQ') }}
        </a>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-50/80">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Order') }}</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Question') }}</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Status') }}</th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($faqs as $faq)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $faq->sort_order }}</td>
                        <td class="px-4 py-3">
                            <span class="font-medium text-gray-900">{{ Str::limit($faq->question_en, 60) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @if($faq->is_active)
                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">{{ __('Active') }}</span>
                            @else
                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">{{ __('Inactive') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-brand-teal transition hover:bg-brand-gold/10">{{ __('Edit') }}</a>
                            <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('Are you sure you want to delete this FAQ?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">{{ __('No FAQs yet. Add one to show on the Contact page.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endcomponent
@endsection
