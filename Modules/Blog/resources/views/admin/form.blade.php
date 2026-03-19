@php
    $post = $post ?? null;
    $locales = config('app.available_locales', ['en', 'ar']);
@endphp
<div>
    <p class="mb-2 text-sm font-medium text-gray-700">{{ __('Translations') }}</p>
    <div class="flex gap-2 border-b border-gray-200">
        @foreach($locales as $locale)
            <button type="button" class="locale-tab rounded-t px-4 py-2 text-sm font-medium {{ $loop->first ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-100' }}" data-locale="{{ $locale }}">{{ $locale === 'en' ? __('English') : __('Arabic') }}</button>
        @endforeach
    </div>
    @foreach($locales as $locale)
        <div class="locale-panel mt-4 space-y-4 {{ $loop->first ? '' : 'hidden' }}" data-locale="{{ $locale }}">
            @include('components.admin.form-field', [
                'name' => "title[{$locale}]",
                'label' => __('Title') . " ({$locale})",
                'type' => 'text',
                'value' => old("title.{$locale}", $post?->getTranslation('title', $locale, false)),
                'required' => $loop->first,
            ])
            @include('components.admin.form-field', [
                'name' => "excerpt[{$locale}]",
                'label' => __('Excerpt') . " ({$locale})",
                'type' => 'textarea',
                'value' => old("excerpt.{$locale}", $post?->getTranslation('excerpt', $locale, false)),
                'attributes' => ['rows' => 2],
            ])
            @include('components.admin.rich-editor', [
                'name' => "body[{$locale}]",
                'id' => 'post_body_' . $locale,
                'label' => __('Body') . " ({$locale})",
                'value' => old("body.{$locale}", $post?->getTranslation('body', $locale, false)),
                'errorKey' => "body.{$locale}",
            ])
            @include('components.admin.form-field', [
                'name' => "meta_title[{$locale}]",
                'label' => __('Meta title') . " ({$locale})",
                'type' => 'text',
                'value' => old("meta_title.{$locale}", $post?->getTranslation('meta_title', $locale, false)),
            ])
            @include('components.admin.form-field', [
                'name' => "meta_description[{$locale}]",
                'label' => __('Meta description') . " ({$locale})",
                'type' => 'textarea',
                'value' => old("meta_description.{$locale}", $post?->getTranslation('meta_description', $locale, false)),
                'attributes' => ['rows' => 2],
            ])
        </div>
    @endforeach
</div>
@include('components.admin.form-field', [
    'name' => 'slug',
    'label' => __('Slug'),
    'type' => 'text',
    'value' => old('slug', $post?->slug),
    'attributes' => ['placeholder' => __('Leave blank to auto-generate from title (EN)')],
])
@include('components.admin.form-field', [
    'name' => 'image',
    'label' => __('Featured image'),
    'type' => 'file',
    'value' => '',
    'attributes' => [
        'accept' => 'image/*',
        'current' => $post?->image,
        'current_url' => $post?->image ? \Illuminate\Support\Facades\Storage::url($post->image) : '',
    ],
])
@include('components.admin.form-field', [
    'name' => 'published_at',
    'label' => __('Published at'),
    'type' => 'datetime-local',
    'value' => old('published_at', $post?->published_at?->format('Y-m-d\TH:i')),
    'attributes' => ['placeholder' => __('Leave empty for draft')],
])
