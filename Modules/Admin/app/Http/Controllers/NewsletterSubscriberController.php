<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsletterSubscriberController
{
    public function index(Request $request): View
    {
        $query = NewsletterSubscriber::query();

        if ($request->filled('search')) {
            $term = '%' . $request->input('search') . '%';
            $query->where('email', 'like', $term);
        }

        $sort = $request->input('sort', 'created_at');
        $order = strtolower($request->input('order', 'desc')) === 'asc' ? 'asc' : 'desc';
        if (in_array($sort, ['id', 'email', 'created_at'], true)) {
            $query->orderBy($sort, $order);
        } else {
            $query->latest();
        }

        $subscribers = $query->paginate(admin_per_page())->withQueryString();

        return view('admin::newsletter.index', compact('subscribers'));
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:newsletter_subscribers,id',
            'action' => 'required|in:delete',
        ]);

        $count = NewsletterSubscriber::whereIn('id', $request->input('ids'))->delete();

        return redirect()
            ->route('admin.newsletter.index', $request->only('search', 'per_page', 'sort', 'order'))
            ->with('success', __(':count record(s) deleted.', ['count' => $count]));
    }
}
