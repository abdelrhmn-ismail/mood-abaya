@extends('admin.layouts.app')

@section('title', __('Testimonials'))
@section('heading', __('Testimonials'))

@section('content')
@component('components.admin.card', ['title' => null])
    <p class="mb-4 text-sm text-gray-600">{{ __('Customer quotes shown on the home and about pages.') }}</p>
    <div class="mb-4">
        <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-teal-dark">
            <span class="material-icons text-lg">add</span> {{ __('Add testimonial') }}
        </a>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-50/80">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Name') }}</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Quote') }}</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Order') }}</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Status') }}</th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($testimonials as $t)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $t->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($t->quote, 80) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $t->sort_order }}</td>
                        <td class="px-4 py-3">
                            @if($t->active)
                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">{{ __('Active') }}</span>
                            @else
                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">{{ __('Inactive') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.testimonials.edit', $t) }}" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-brand-teal transition hover:bg-brand-gold/10">{{ __('Edit') }}</a>
                            <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('Are you sure you want to delete this testimonial?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">{{ __('No testimonials yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endcomponent
@endsection
