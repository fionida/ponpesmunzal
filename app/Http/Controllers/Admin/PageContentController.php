<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageContentController extends Controller
{
    public function edit(): View
    {
        $groups = PageContent::query()
            ->orderBy('group')
            ->orderBy('id')
            ->get()
            ->groupBy('group');

        return view('admin.page-contents.edit', compact('groups'));
    }

    public function update(Request $request): RedirectResponse
    {
        $values = $request->input('values', []);

        foreach ($values as $key => $value) {
            PageContent::query()->where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'Konten halaman berhasil disimpan.');
    }
}
