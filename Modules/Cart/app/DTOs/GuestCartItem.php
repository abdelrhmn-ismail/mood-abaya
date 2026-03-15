<?php

namespace Modules\Cart\DTOs;

use App\Models\Product;
use App\Models\ProductVariant;

/**
 * Value object for a guest cart line (from cache). Mirrors CartItem interface for views/checkout.
 */
class GuestCartItem
{
    public function __construct(
        public string $id,
        public int $product_id,
        public ?int $product_variant_id,
        public int $quantity,
        public Product $product,
        public ?ProductVariant $productVariant,
    ) {}

    public function getEffectivePrice(): float
    {
        if ($this->product_variant_id && $this->productVariant) {
            return (float) $this->productVariant->price;
        }
        return (float) ($this->product->price ?? 0);
    }
}
