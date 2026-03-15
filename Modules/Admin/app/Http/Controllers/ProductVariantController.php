<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductVariantController
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'sku' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'attributes' => 'nullable|string|max:1000', // JSON string e.g. {"Size":"M","Color":"Black"}
        ]);

        $attributes = null;
        if (! empty(trim($data['attributes'] ?? ''))) {
            $dec = json_decode($data['attributes'], true);
            $attributes = is_array($dec) ? $dec : null;
        }

        ProductVariant::create([
            'product_id' => $product->id,
            'sku' => $data['sku'] ?? null,
            'price' => $data['price'],
            'stock' => (int) $data['stock'],
            'attributes' => $attributes,
        ]);

        return redirect()->route('admin.products.edit', $product)->with('success', __('Variant added.'));
    }

    public function destroy(Product $product, ProductVariant $variant): RedirectResponse
    {
        if ($variant->product_id !== $product->id) {
            abort(404);
        }
        $variant->delete();

        return redirect()->route('admin.products.edit', $product)->with('success', __('Variant removed.'));
    }
}
