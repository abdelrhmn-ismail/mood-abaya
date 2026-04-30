<?php

namespace Modules\Payment\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Builds the Tabby checkout session payload from a local Order
 * and delegates the API call to TabbyPaymentService.
 */
class TabbyCheckoutService
{
    public function __construct(
        private TabbyPaymentService $tabbyService
    ) {}

    /**
     * Create a Tabby checkout session for the given order.
     * Returns the Tabby redirect URL or null on failure.
     */
    public function createSession(Order $order): ?string
    {
        $order->load('items.product', 'user');
        $user = $order->user ?? Auth::user();
        $billing = $order->billing_address ? json_decode($order->billing_address, true) : [];
        $shipping = $order->shipping_address ? json_decode($order->shipping_address, true) : [];

        // Build order items
        $orderItems = [];
        foreach ($order->items as $item) {
            $orderItems[] = [
                'title'        => $item->product?->name ?? 'Product',
                'quantity'     => $item->quantity,
                'unit_price'   => number_format((float) $item->price, 2, '.', ''),
                'category'     => 'Fashion',
                'reference_id' => (string) $item->id,
            ];
        }

        $totalAmount = number_format((float) $order->total, 2, '.', '');

        // Build buyer info
        $buyer = [
            'phone' => $billing['phone'] ?? $user?->phone ?? '',
            'email' => $user?->email ?? '',
            'name'  => $billing['full_name'] ?? $user?->name ?? 'Guest',
        ];

        $data = [
            'payment' => [
                'amount'   => $totalAmount,
                'currency' => 'SAR',
                'buyer'    => $buyer,
                'shipping_address' => [
                    'city'    => $shipping['city'] ?? $billing['city'] ?? null,
                    'address' => $shipping['address_line_1'] ?? $billing['address_line_1'] ?? null,
                    'zip'     => $shipping['postal_code'] ?? $billing['postal_code'] ?? null,
                ],
                'order' => [
                    'reference_id'    => $order->order_number,
                    'items'           => $orderItems,
                    'tax_amount'      => '0.00',
                    'shipping_amount' => number_format((float) $order->shipping_amount, 2, '.', ''),
                    'discount_amount' => '0.00',
                ],
                'buyer_history' => [
                    'registered_since' => $user?->created_at?->utc()->format('Y-m-d\TH:i:s\Z') ?? now()->utc()->format('Y-m-d\TH:i:s\Z'),
                    'loyalty_level'    => 0,
                ],
            ],
            'lang'          => app()->getLocale() === 'ar' ? 'ar' : 'en',
            'merchant_code' => $this->tabbyService->getMerchantCode(),
            'merchant_urls' => [
                'success' => route('tabby.success'),
                'cancel'  => route('tabby.cancel'),
                'failure' => route('tabby.failure'),
            ],
        ];

        try {
            Log::info('Tabby: Creating checkout session', [
                'order_number' => $order->order_number,
                'amount'       => $totalAmount,
            ]);

            $session = $this->tabbyService->createCheckoutSession($data);

            // Extract redirect URL from Tabby response
            $redirectUrl = $session->configuration->available_products->installments[0]->web_url ?? null;

            if (!$redirectUrl) {
                Log::error('Tabby: No redirect URL in session response', [
                    'response' => json_encode($session),
                ]);
                return null;
            }

            Log::info('Tabby: Checkout session created', [
                'session_id'   => $session->id ?? 'unknown',
                'redirect_url' => $redirectUrl,
            ]);

            return $redirectUrl;
        } catch (\Exception $e) {
            Log::error('Tabby: Failed to create checkout session', [
                'order_number' => $order->order_number,
                'error'        => $e->getMessage(),
            ]);
            return null;
        }
    }
}
