<?php

namespace Modules\Contact\Http\Controllers\Admin;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Contact\Http\Requests\Admin\BulkContactMessageActionRequest;
use Modules\Contact\Services\Admin\ContactMessageService;

class ContactMessageController
{
    public function __construct(
        private ContactMessageService $contactMessageService
    ) {}

    public function index(Request $request): View
    {
        $messages = $this->contactMessageService->getMessages(
            $request->only('read', 'search', 'sort', 'order'),
            admin_per_page()
        );

        return view('contact::admin.contacts.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage): View
    {
        $this->contactMessageService->markAsRead($contactMessage);

        return view('contact::admin.contacts.show', compact('contactMessage'));
    }

    public function bulkAction(BulkContactMessageActionRequest $request): RedirectResponse
    {
        $ids = $request->input('ids');
        $action = $request->input('action');
        $count = 0;
        if ($action === 'mark_read') {
            $count = $this->contactMessageService->bulkMarkAsRead($ids);
        } elseif ($action === 'delete') {
            $count = $this->contactMessageService->bulkDelete($ids);
        }

        return redirect()->route('admin.contacts.index', $request->only('read', 'search', 'per_page', 'sort', 'order'))
            ->with('success', __(':count record(s) updated.', ['count' => $count]));
    }
}
