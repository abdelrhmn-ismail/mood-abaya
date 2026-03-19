@extends('admin.layouts.app')

@section('title', __('Blog / News'))
@section('heading', __('Blog / News'))

@section('content')
@component('components.admin.card', ['title' => null])
    <p class="mb-4 text-sm text-gray-600">{{ __('Manage blog or news posts for SEO and announcements.') }}</p>
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <span class="text-sm text-gray-500">{{ $posts->total() }} {{ __('items') }}</span>
        <a href="{{ route('blog::admin.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-teal-dark">
            <span class="material-icons text-lg">add</span> {{ __('Add post') }}
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
                                <span class="material-icons text-base">{{ request('order', 'desc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}</span>
                            @else
                                <span class="material-icons text-base opacity-50">unfold_more</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        <a href="{{ admin_sort_url('published_at') }}" class="inline-flex items-center gap-1 transition hover:text-brand-teal">
                            {{ __('Published') }}
                            @if(request('sort') === 'published_at' || !request('sort'))
                                <span class="material-icons text-base">{{ request('order', 'desc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}</span>
                            @else
                                <span class="material-icons text-base opacity-50">unfold_more</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($posts as $post)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3">
                            <span class="font-medium text-gray-900">{{ Str::limit($post->title, 50) }}</span>
                            @if(!$post->published_at || $post->published_at->isFuture())
                                <span class="ml-2 inline-flex rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-800">{{ __('Draft') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $post->published_at?->format('Y-m-d H:i') ?? '—' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100">{{ __('View') }}</a>
                            <a href="{{ route('blog::admin.edit', $post) }}" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-brand-teal transition hover:bg-brand-gold/10">{{ __('Edit') }}</a>
                            <form action="{{ route('blog::admin.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('Are you sure you want to delete this post?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-8 text-center text-sm text-gray-500">{{ __('No posts yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($posts->hasPages())
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
                <label for="admin-per-page-posts" class="text-sm text-slate-600">{{ __('Per page') }}</label>
                <select name="per_page" id="admin-per-page-posts" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
                    @foreach(admin_per_page_options() as $n)
                        <option value="{{ $n }}" {{ $posts->perPage() == $n ? 'selected' : '' }}>{{ $n }}</option>
                    @endforeach
                </select>
            </form>
            <div>{{ $posts->withQueryString()->links() }}</div>
        </div>
    @endif
@endcomponent
@endsection
