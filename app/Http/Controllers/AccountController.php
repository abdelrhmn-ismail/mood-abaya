<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Order\Services\OrderService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $orders = $user->orders()->with('items.product')->orderByDesc('created_at')->limit(50)->get();

        return view('frontend.account', [
            'user' => $user,
            'orders' => $orders,
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
