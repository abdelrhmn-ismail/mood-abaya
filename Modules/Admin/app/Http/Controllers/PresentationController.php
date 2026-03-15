<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\View\View;

class PresentationController
{
    /**
     * Show the presentations index page with links to AR and EN versions.
     */
    public function index(): View
    {
        $arUrl = asset('presentations/ar/index.html');
        $enUrl = asset('presentations/en/index.html');

        return view('admin::presentations.index', compact('arUrl', 'enUrl'));
    }
}
