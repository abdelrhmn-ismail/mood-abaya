<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'sku', 'price', 'stock', 'image', 'attributes', 'sort_order'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'attributes' => 'array',
            'sort_order' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getDisplayName(): string
    {
        if (empty($this->attributes) || ! is_array($this->attributes)) {
            return $this->sku ?? (string) $this->id;
        }
        return implode(' / ', array_map(fn ($k, $v) => "{$k}: {$v}", array_keys($this->attributes), $this->attributes));
    }
}
