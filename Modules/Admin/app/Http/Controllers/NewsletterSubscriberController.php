<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Admin\Http\Requests\BulkNewsletterActionRequest;
use Modules\Admin\Services\NewsletterService;

class NewsletterSubscriberController
{
    public function __construct(private NewsletterService $newsletterService) {}

    public function index(Request $request): View
    {
        $subscribers = $this->newsletterService->getAll(
            $request->only('search', 'sort', 'order'),
            admin_per_page()
        );

        return view('admin::newsletter.index', compact('subscribers'));
    }

    public function bulkAction(BulkNewsletterActionRequest $request): RedirectResponse
    {
        $count = $this->newsletterService->bulkDelete($request->input('ids'));

        return redirect()
            ->route('admin.newsletter.index', $request->only('search', 'per_page', 'sort', 'order'))
            ->with('success', __(':count record(s) deleted.', ['count' => $count]));
    }
}
