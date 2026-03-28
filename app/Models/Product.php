<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'description'];

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'tags',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'sku',
        'barcode',
        'price',
        'compare_at_price',
        'image',
        'video',
        'stock',
        'min_order_qty',
        'max_order_qty',
        'weight_kg',
        'active',
        'featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'weight_kg' => 'decimal:2',
            'active' => 'boolean',
            'featured' => 'boolean',
            'stock' => 'integer',
            'min_order_qty' => 'integer',
            'max_order_qty' => 'integer',
        ];
    }

    /** Whether the product has a discount (compare_at_price > price). */
    public function hasDiscount(): bool
    {
        return $this->compare_at_price !== null
            && (float) $this->compare_at_price > (float) $this->price;
    }

    /** Discount percentage (0–100), or null if no discount. */
    public function discountPercent(): ?int
    {
        if (! $this->hasDiscount()) {
            return null;
        }
        $compare = (float) $this->compare_at_price;
        $price = (float) $this->price;

        return (int) round((($compare - $price) / $compare) * 100);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /** All images for display: main image first, then gallery images. */
    public function getDisplayImages(): Collection
    {
        $list = collect();
        if ($this->image) {
            $list->push((object) ['image' => $this->image, 'is_main' => true]);
        }
        foreach ($this->images as $img) {
            $list->push((object) ['image' => $img->image, 'is_main' => false]);
        }

        return $list->isEmpty() ? collect() : $list;
    }

    /** First image URL (main or first gallery) for cards/thumbnails. */
    public function getFirstImageAttribute(): ?string
    {
        $first = $this->getDisplayImages()->first();

        return $first ? $first->image : null;
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order');
    }

    /** Whether this product has variants (size/color etc.). */
    public function hasVariants(): bool
    {
        return $this->variants()->exists();
    }

    /** Option names for variant selector (e.g. ["Size", "Color"]) derived from first variant's attributes. */
    public function getVariantOptionNames(): array
    {
        $first = $this->variants()->first();
        if (! $first || empty($first->attributes) || ! is_array($first->attributes)) {
            return [];
        }

        return array_keys($first->attributes);
    }

    /** Find variant by attributes (e.g. ["Size" => "M", "Color" => "Black"]). */
    public function findVariantByAttributes(array $attributes): ?ProductVariant
    {
        if (empty($attributes)) {
            return null;
        }
        foreach ($this->variants as $v) {
            if (is_array($v->attributes) && $v->attributes === $attributes) {
                return $v;
            }
        }

        return null;
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    /** Average rating (1-5) from visible reviews, or null if no reviews. */
    public function averageRating(): ?float
    {
        $avg = $this->reviews()->where('is_visible', true)->avg('rating');

        return $avg !== null ? round((float) $avg, 1) : null;
    }

    /** Count of visible reviews. */
    public function visibleReviewsCount(): int
    {
        return $this->reviews()->where('is_visible', true)->count();
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
