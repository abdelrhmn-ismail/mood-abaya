<?php

namespace Modules\Payment\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class BankPaymentService
{
    public function storeProof(UploadedFile $file): string
    {
        $dir = 'payments';
        $name = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs($dir, $name, 'public');
        return $dir . '/' . $name;
    }

    public function getPaymentsPendingApproval()
    {
        return \App\Models\Payment::where('method', 'bank')
            ->where('status', 'pending_approval')
            ->with('order')
            ->orderByDesc('created_at')
            ->get();
    }
}
