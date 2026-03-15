<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController
{
    public function index(Request $request): View
    {
        $sort = $request->get('sort', 'start_at');
        $order = strtolower($request->get('order', 'desc')) === 'asc' ? 'asc' : 'desc';
        $allowedSort = ['title', 'sort_order', 'active', 'start_at', 'end_at', 'created_at', 'id'];
        if (!in_array($sort, $allowedSort, true)) {
            $sort = 'start_at';
        }
        $banners = Banner::orderBy($sort, $order)
            ->paginate(admin_per_page())
            ->withQueryString();

        return view('admin::banners.index', compact('banners'));
    }

    public function create(): View
    {
        $banner = new Banner;

        return view('admin::banners.create', compact('banner'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:500',
            'link' => 'nullable|string|max:500',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'sort_order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['active'] = $request->boolean('active');
        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', __('Banner added.'));
    }

    public function edit(Banner $banner): View
    {
        return view('admin::banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:500',
            'link' => 'nullable|string|max:500',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'sort_order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['active'] = $request->boolean('active');
        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', __('Banner updated.'));
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', __('Banner deleted.'));
    }
}
