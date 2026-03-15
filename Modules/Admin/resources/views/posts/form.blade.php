@php $post = $post ?? null; @endphp
@include('admin::components.form-field', [
    'name' => 'title',
    'label' => __('Title'),
    'type' => 'text',
    'value' => old('title', $post?->title),
    'required' => true,
])
@include('admin::components.form-field', [
    'name' => 'slug',
    'label' => __('Slug'),
    'type' => 'text',
    'value' => old('slug', $post?->slug),
    'attributes' => ['placeholder' => __('Leave blank to auto-generate from title')],
])
@include('admin::components.form-field', [
    'name' => 'excerpt',
    'label' => __('Excerpt'),
    'type' => 'textarea',
    'value' => old('excerpt', $post?->excerpt),
    'attributes' => ['rows' => 2],
])
@include('admin::components.rich-editor', [
    'name' => 'body',
    'id' => 'post_body',
    'label' => __('Body'),
    'value' => old('body', $post?->body),
    'errorKey' => 'body',
])
@include('admin::components.form-field', [
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
@include('admin::components.form-field', [
    'name' => 'published_at',
    'label' => __('Published at'),
    'type' => 'datetime-local',
    'value' => old('published_at', $post?->published_at?->format('Y-m-d\TH:i')),
    'attributes' => ['placeholder' => __('Leave empty for draft')],
])
@include('admin::components.form-field', ['name' => 'meta_title', 'label' => __('Meta title'), 'type' => 'text', 'value' => old('meta_title', $post?->meta_title)])
@include('admin::components.form-field', ['name' => 'meta_description', 'label' => __('Meta description'), 'type' => 'textarea', 'value' => old('meta_description', $post?->meta_description), 'attributes' => ['rows' => 2]])
