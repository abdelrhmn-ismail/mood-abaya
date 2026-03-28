<?php

namespace Modules\Payment\Http\Controllers\Admin;

use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Payment\Http\Requests\Admin\StorePaymentMethodRequest;
use Modules\Payment\Http\Requests\Admin\UpdatePaymentMethodRequest;
use Modules\Payment\Services\Admin\PaymentMethodAdminService;

class PaymentMethodController
{
    public function __construct(
        private PaymentMethodAdminService $paymentMethodAdminService
    ) {}

    public function index(): View
    {
        $methods = $this->paymentMethodAdminService->getAllOrdered();

        return view('payment::admin.payment-methods.index', compact('methods'));
    }

    public function create(): View
    {
        return view('payment::admin.payment-methods.create');
    }

    public function store(StorePaymentMethodRequest $request): RedirectResponse
    {
        $this->paymentMethodAdminService->create($request->validated());

        return redirect()
            ->route('admin.payment-methods.index')
            ->with('success', __('Payment method created.'));
    }

    public function edit(PaymentMethod $paymentMethod): View
    {
        return view('payment::admin.payment-methods.edit', compact('paymentMethod'));
    }

    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod): RedirectResponse
    {
        $this->paymentMethodAdminService->update($paymentMethod, $request->validated());

        return redirect()
            ->route('admin.payment-methods.index')
            ->with('success', __('Payment method updated.'));
    }

    public function destroy(PaymentMethod $paymentMethod): RedirectResponse
    {
        $ok = $this->paymentMethodAdminService->delete($paymentMethod);
        if (! $ok) {
            return redirect()
                ->route('admin.payment-methods.index')
                ->with('error', __('This payment method cannot be deleted (system method or existing orders).'));
        }

        return redirect()
            ->route('admin.payment-methods.index')
            ->with('success', __('Payment method removed.'));
    }

    public function toggle(PaymentMethod $paymentMethod): RedirectResponse
    {
        $this->paymentMethodAdminService->toggleActive($paymentMethod);

        return redirect()
            ->route('admin.payment-methods.index')
            ->with('success', 'Updated.');
    }
}
