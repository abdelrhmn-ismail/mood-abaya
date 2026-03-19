<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccountController extends Controller
{
    public function __construct(private AccountService $accountService) {}

    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user && $user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $data = $this->accountService->getAccountData($user, $request->input('order'));

        return view('frontend.account', $data);
    }

    public function showOrder(Request $request, string $orderNumber): View
    {
        $order = $this->accountService->getOrderForUser($orderNumber, $request->user()->id);

        if (!$order) {
            throw new NotFoundHttpException(__('Order not found.'));
        }

        return view('frontend.order-show', compact('order'));
    }
}
