<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(Request $request): View
    {
        $items = Faq::query()
            ->when($request->q, fn ($q, $s) => $q->where('question', 'like', "%{$s}%"))
            ->orderBy('sort_order')->orderBy('id')
            ->paginate(15)->withQueryString();

        return view('admin.faqs.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.faqs.form', ['item' => new Faq]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active', true);
        Faq::query()->create($data);

        return redirect()->route('admin.faq.index')->with('success', 'FAQ ditambahkan.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.form', ['item' => $faq]);
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $faq->update($data);

        return redirect()->route('admin.faq.index')->with('success', 'FAQ diperbarui.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return back()->with('success', 'FAQ dihapus.');
    }

    public function bulk(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:faqs,id'],
            'action' => ['required', 'in:delete,aktif,nonaktif'],
        ]);

        if ($data['action'] === 'delete') {
            Faq::query()->whereIn('id', $data['ids'])->delete();

            return back()->with('success', count($data['ids']).' FAQ dihapus.');
        }

        Faq::query()->whereIn('id', $data['ids'])->update(['is_active' => $data['action'] === 'aktif']);

        return back()->with('success', count($data['ids']).' FAQ diperbarui.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
