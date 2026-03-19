<?php

namespace Modules\Shop\Services;

use App\Models\Order;
use App\Models\ProductReview;

class ReviewService
{
    public function storeReview(int $userId, array $data): ProductReview|string
    {
        $order = Order::where('id', $data['order_id'])
            ->where('user_id', $userId)
            ->where('status', 'delivered')
            ->firstOrFail();

        $order->load('items');

        if (!$order->items->contains('product_id', (int) $data['product_id'])) {
            abort(403, __('Product was not in this order.'));
        }

        $exists = ProductReview::where('order_id', $order->id)
            ->where('product_id', $data['product_id'])
            ->where('user_id', $userId)
            ->exists();

        if ($exists) {
            return 'already_reviewed';
        }

        return ProductReview::create([
            'product_id' => $data['product_id'],
            'user_id' => $userId,
            'order_id' => $order->id,
            'rating' => (int) $data['rating'],
            'comment' => !empty($data['comment']) ? $data['comment'] : null,
            'is_visible' => true,
        ]);
    }
}
