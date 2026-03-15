<?php

namespace Modules\Order\Services;

use App\Models\BillingAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\ShippingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Cart\Services\CartService;
use Modules\Payment\Services\BankPaymentService;
use Modules\Payment\Services\PaymentService;

class CheckoutService
{
    public function __construct(
        private CartService $cartService,
        private PaymentService $paymentService,
        private BankPaymentService $bankPaymentService,
        private ShippingService $shippingService
    ) {}

    public function getCheckoutData(?string $shippingZoneId = null): array
    {
        $items = $this->cartService->getCart();
        $subtotal = $this->cartService->getTotal();
        $billingAddresses = [];
        if (Auth::id()) {
            $billingAddresses = BillingAddress::where('user_id', Auth::id())
                ->orderByDesc('is_default')
                ->orderBy('label')
                ->get();
        }
        $shipping = $this->shippingService->calculate($subtotal, $shippingZoneId);
        $shippingAmount = $shipping['amount'];
        $shippingLabel = $shipping['label'];
        $total = round($subtotal + $shippingAmount, 2);
        $shippingZones = $this->shippingService->getType() === 'zones' ? $this->shippingService->getZones() : [];
        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'shippingAmount' => $shippingAmount,
            'shippingLabel' => $shippingLabel,
            'shippingZones' => $shippingZones,
            'shippingType' => $this->shippingService->getType(),
            'shippingFreeOver' => $this->shippingService->getFreeOver(),
            'total' => $total,
            'billingAddresses' => $billingAddresses,
        ];
    }

    /** @param array<string, mixed>|null $billingAddress Snapshot to store on order (null = use shipping as billing) */
    public function placeOrder(array $address, string $paymentMethod, $proofFile = null, ?array $billingAddress = null, float $shippingAmount = 0, ?string $shippingLabel = null): Order
    {
        $paymentMethod = $paymentMethod === 'bank' ? 'bank' : 'cash';
        $items = $this->cartService->getCart();
        if ($items->isEmpty()) {
            throw new \InvalidArgumentException(__('Your cart is empty.'));
        }

        $proofPath = null;
        if ($paymentMethod === 'bank' && $proofFile) {
            $proofPath = $this->bankPaymentService->storeProof($proofFile);
        }

        $billingSnapshot = $billingAddress !== null
            ? json_encode($billingAddress)
            : null;

        return DB::transaction(function () use ($items, $address, $paymentMethod, $proofPath, $billingSnapshot, $shippingAmount, $shippingLabel) {
            $orderNumber = $this->generateOrderNumber();
            $subtotal = 0;

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'status' => 'pending',
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentMethod === 'bank' ? 'pending_approval' : 'pending',
                'shipping_address' => is_array($address) ? json_encode($address) : $address,
                'billing_address' => $billingSnapshot,
                'notes' => $address['notes'] ?? null,
                'total' => 0,
                'shipping_amount' => $shippingAmount,
                'shipping_label' => $shippingLabel,
            ]);

            foreach ($items as $cartItem) {
                $price = $cartItem->getEffectivePrice();
                $qty = $cartItem->quantity;
                $lineTotal = round($price * $qty, 2);
                $subtotal += $lineTotal;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $qty,
                    'price' => $price,
                ]);
            }

            $order->update(['total' => round($subtotal + $shippingAmount, 2)]);

            $this->paymentService->createPaymentForOrder($order, $paymentMethod, $proofPath);

            $this->cartService->clearCart();

            return $order->fresh(['items.product', 'payments']);
        });
    }

    protected function generateOrderNumber(): string
    {
        $prefix = 'MO-' . date('Ymd') . '-';
        $last = Order::where('order_number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('order_number');
        $seq = $last ? (int) substr($last, strlen($prefix)) + 1 : 1;
        return $prefix . str_pad((string) $seq, 5, '0', STR_PAD_LEFT);
    }
}
