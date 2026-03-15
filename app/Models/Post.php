<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'excerpt', 'body', 'meta_title', 'meta_description'];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'image',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public static function booted()
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $title = $post->title;
                $source = is_array($title)
                    ? ($title['en'] ?? $title['ar'] ?? '')
                    : (string) $title;
                $post->slug = Str::slug($source ?: 'post');
            }
        });
    }
}
