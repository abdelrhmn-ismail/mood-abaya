<?php

namespace Modules\Payment\Services;

use App\Models\Payment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BankPaymentService
{
    public function storeProof(UploadedFile $file): string
    {
        $name = Str::uuid().'.'.$file->getClientOriginalExtension();
        $relativeDir = 'media/payments';
        $fullDir = public_path($relativeDir);
        File::makeDirectory($fullDir, 0755, true, true);
        $file->move($fullDir, $name);

        return $relativeDir.'/'.$name;
    }

    public function getPaymentsPendingApproval()
    {
        return Payment::where('method', 'bank')
            ->where('status', 'pending_approval')
            ->with('order')
            ->orderByDesc('created_at')
            ->get();
    }
}
