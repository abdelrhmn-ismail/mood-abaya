<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController
{
    public function index(Request $request): View
    {
        $perPage = admin_per_page();
        $query = User::query()->withCount('orders');

        if ($request->filled('search')) {
            $term = '%' . $request->get('search') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('phone', 'like', $term);
            });
        }
        if ($request->has('is_admin') && $request->get('is_admin') !== '') {
            $query->where('is_admin', (bool) $request->get('is_admin'));
        }

        $sort = $request->get('sort', 'created_at');
        $order = strtolower($request->get('order', 'desc')) === 'asc' ? 'asc' : 'desc';
        $allowedSort = ['id', 'name', 'email', 'created_at', 'is_admin'];
        if (in_array($sort, $allowedSort, true)) {
            $query->orderBy($sort, $order);
        } else {
            $query->latest();
        }

        $users = $query->paginate($perPage)->withQueryString();

        return view('admin::users.index', compact('users'));
    }
}
