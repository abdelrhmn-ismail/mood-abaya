<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Order\Services\OrderService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccountController extends Controller
{
    public function index(Request $request, OrderService $orderService): View|RedirectResponse
    {
        $user = $request->user();
        if ($user && $user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        $orders = $user->orders()->with('items.product')->orderByDesc('created_at')->limit(50)->get();

        $selectedOrder = null;
        $reviewedProductIds = [];
        if ($request->filled('order')) {
            $selectedOrder = $orderService->getOrderByNumberForUser($request->input('order'), (int) $user->id);
            if ($selectedOrder) {
                $selectedOrder->load('items.product', 'payments', 'shippings');
                $reviewedProductIds = ProductReview::where('order_id', $selectedOrder->id)
                    ->where('user_id', $user->id)
                    ->pluck('product_id')
                    ->all();
            }
        }

        return view('frontend.account', [
            'user' => $user,
            'orders' => $orders,
            'selectedOrder' => $selectedOrder,
            'reviewedProductIds' => $reviewedProductIds,
        ]);
    }

    public function showOrder(Request $request, string $orderNumber, OrderService $orderService): View
    {
        $order = $orderService->getOrderByNumberForUser($orderNumber, $request->user()->id);
        if (!$order) {
            throw new NotFoundHttpException(__('Order not found.'));
        }
        $order->load('items.product', 'payments', 'shippings');

        return view('frontend.order-show', compact('order'));
    }
}
