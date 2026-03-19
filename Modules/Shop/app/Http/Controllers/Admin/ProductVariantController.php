<?php

namespace Modules\Shop\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Modules\Shop\Http\Requests\Admin\StoreProductVariantRequest;

class ProductVariantController
{
    public function store(StoreProductVariantRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

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
