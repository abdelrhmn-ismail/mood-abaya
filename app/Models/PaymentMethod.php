<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    protected $fillable = [
        'code',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'instructions_en',
        'instructions_ar',
        'is_active',
        'sort_order',
        'requires_proof',
        'requires_admin_approval',
        'is_system',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requires_proof' => 'boolean',
        'requires_admin_approval' => 'boolean',
        'is_system' => 'boolean',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'method', 'code');
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function nameForLocale(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        if ($locale === 'ar' && $this->name_ar) {
            return $this->name_ar;
        }

        return $this->name_en;
    }

    public function descriptionForLocale(?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        if ($locale === 'ar' && $this->description_ar) {
            return $this->description_ar;
        }

        return $this->description_en;
    }

    public function instructionsForLocale(?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        if ($locale === 'ar' && $this->instructions_ar) {
            return $this->instructions_ar;
        }

        return $this->instructions_en;
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
