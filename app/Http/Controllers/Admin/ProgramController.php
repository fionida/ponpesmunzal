<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(Request $request): View
    {
        $items = Program::query()
            ->when($request->q, fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when($request->status === 'aktif', fn ($q) => $q->where('is_active', true))
            ->when($request->status === 'nonaktif', fn ($q) => $q->where('is_active', false))
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.programs.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.programs.form', ['item' => new Program]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programs', 'public');
        }
        Program::query()->create($data);

        return redirect()->route('admin.program.index')->with('success', 'Program ditambahkan.');
    }

    public function edit(Program $program): View
    {
        return view('admin.programs.form', ['item' => $program]);
    }

    public function update(Request $request, Program $program): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($program->image) {
                Storage::disk('public')->delete($program->image);
            }
            $data['image'] = $request->file('image')->store('programs', 'public');
        }
        $program->update($data);

        return redirect()->route('admin.program.index')->with('success', 'Program diperbarui.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        if ($program->image) {
            Storage::disk('public')->delete($program->image);
        }
        $program->delete();

        return back()->with('success', 'Program dihapus.');
    }

    public function bulk(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:programs,id'],
            'action' => ['required', 'in:delete,aktif,nonaktif'],
        ]);

        if ($data['action'] === 'delete') {
            $items = Program::query()->whereIn('id', $data['ids'])->get();
            foreach ($items as $item) {
                if ($item->image) {
                    Storage::disk('public')->delete($item->image);
                }
                $item->delete();
            }

            return back()->with('success', count($data['ids']).' program dihapus.');
        }

        Program::query()->whereIn('id', $data['ids'])->update([
            'is_active' => $data['action'] === 'aktif',
        ]);

        return back()->with('success', count($data['ids']).' program diperbarui.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);
    }
}
