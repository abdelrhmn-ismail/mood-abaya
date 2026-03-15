<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'session_id', 'product_id', 'product_variant_id', 'quantity'];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /** Effective price for this cart line (variant price or product price). */
    public function getEffectivePrice(): float
    {
        if ($this->product_variant_id && $this->productVariant) {
            return (float) $this->productVariant->price;
        }
        return (float) ($this->product->price ?? 0);
    }
}
