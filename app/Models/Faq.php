<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question_en',
        'question_ar',
        'answer_en',
        'answer_ar',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getQuestionAttribute(): string
    {
        $locale = app()->getLocale();

        return ($locale === 'ar' && $this->question_ar) ? $this->question_ar : $this->question_en;
    }

    public function getAnswerAttribute(): string
    {
        $locale = app()->getLocale();

        return ($locale === 'ar' && $this->answer_ar) ? $this->answer_ar : $this->answer_en;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
