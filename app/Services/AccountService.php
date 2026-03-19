<?php

namespace App\Services;

use App\Models\BillingAddress;
use App\Models\ProductReview;
use App\Models\User;
use Modules\Cart\Services\CartService;
use Modules\Order\Services\OrderService;

class AccountService
{
    public function __construct(
        private OrderService $orderService,
        private CartService $cartService,
        private WishlistService $wishlistService,
    ) {}

    public function getAccountData(User $user, ?string $orderNumber = null): array
    {
        $orders = $user->orders()
            ->with('items.product')
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        $selectedOrder = null;
        $reviewedProductIds = [];

        if ($orderNumber) {
            $selectedOrder = $this->orderService->getOrderByNumberForUser($orderNumber, (int) $user->id);
            if ($selectedOrder) {
                $selectedOrder->load('items.product', 'payments', 'shippings');
                $reviewedProductIds = ProductReview::where('order_id', $selectedOrder->id)
                    ->where('user_id', $user->id)
                    ->pluck('product_id')
                    ->all();
            }
        }

        return [
            'user' => $user,
            'orders' => $orders,
            'selectedOrder' => $selectedOrder,
            'reviewedProductIds' => $reviewedProductIds,
            'wishlistItems' => $this->wishlistService->getItems(),
            'cartItems' => $this->cartService->getCart(),
            'cartTotal' => $this->cartService->getTotal(),
            'billingAddresses' => BillingAddress::where('user_id', $user->id)
                ->orderByDesc('is_default')
                ->orderBy('label')
                ->get(),
        ];
    }

    public function getOrderForUser(string $orderNumber, int $userId): ?\App\Models\Order
    {
        $order = $this->orderService->getOrderByNumberForUser($orderNumber, $userId);
        $order?->load('items.product', 'payments', 'shippings');

        return $order;
    }
}
