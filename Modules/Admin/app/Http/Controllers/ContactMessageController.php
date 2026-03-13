<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\View\View;
use Modules\Admin\Services\ContactMessageService;

class ContactMessageController
{
    public function __construct(
        private ContactMessageService $contactMessageService
    ) {}

    public function index(): View
    {
        $messages = $this->contactMessageService->getMessages();

        return view('admin::contacts.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage): View
    {
        $this->contactMessageService->markAsRead($contactMessage);

        return view('admin::contacts.show', compact('contactMessage'));
    }
}
