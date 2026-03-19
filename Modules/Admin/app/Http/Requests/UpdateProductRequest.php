<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|array',
            'name.en' => 'nullable|string|max:255',
            'name.ar' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|array',
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
            'sku' => 'nullable|string|max:100',
            'barcode' => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:500',
            'tags' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'delete_image_ids' => 'nullable|array',
            'delete_image_ids.*' => 'integer|exists:product_images,id',
            'stock' => 'nullable|integer|min:0',
            'min_order_qty' => 'nullable|integer|min:1',
            'max_order_qty' => 'nullable|integer|min:1',
            'weight_kg' => 'nullable|numeric|min:0',
            'active' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
        ];
    }
}
