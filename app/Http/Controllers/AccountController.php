<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
}
