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

    /** Gateway codes that have dedicated integrations & settings pages. */
    private const GATEWAY_CODES = ['tabby'];

    public function index(): View
    {
        $all = $this->paymentMethodAdminService->getAllOrdered();

        // Split: gateway integrations vs manual/custom methods
        $gatewayMethods = $all->filter(fn ($m) => in_array($m->code, self::GATEWAY_CODES, true));
        $methods        = $all->reject(fn ($m) => in_array($m->code, self::GATEWAY_CODES, true));

        return view('payment::admin.payment-methods.index', compact('methods', 'gatewayMethods'));
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
