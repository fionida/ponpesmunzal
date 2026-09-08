<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FacilityController extends Controller
{
    public function index(Request $request): View
    {
        $items = Facility::query()
            ->when($request->q, fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when($request->group, fn ($q, $g) => $q->where('group', $g))
            ->orderBy('sort_order')->orderBy('id')
            ->paginate(15)->withQueryString();

        return view('admin.facilities.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.facilities.form', ['item' => new Facility]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('facilities', 'public');
        }
        Facility::query()->create($data);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas ditambahkan.');
    }

    public function edit(Facility $fasilitas): View
    {
        return view('admin.facilities.form', ['item' => $fasilitas]);
    }

    public function update(Request $request, Facility $fasilitas): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($fasilitas->image) {
                Storage::disk('public')->delete($fasilitas->image);
            }
            $data['image'] = $request->file('image')->store('facilities', 'public');
        }
        $fasilitas->update($data);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas diperbarui.');
    }

    public function destroy(Facility $fasilitas): RedirectResponse
    {
        if ($fasilitas->image) {
            Storage::disk('public')->delete($fasilitas->image);
        }
        $fasilitas->delete();

        return back()->with('success', 'Fasilitas dihapus.');
    }

    public function bulk(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:facilities,id'],
            'action' => ['required', 'in:delete,aktif,nonaktif'],
        ]);

        if ($data['action'] === 'delete') {
            foreach (Facility::query()->whereIn('id', $data['ids'])->get() as $item) {
                if ($item->image) {
                    Storage::disk('public')->delete($item->image);
                }
                $item->delete();
            }

            return back()->with('success', count($data['ids']).' fasilitas dihapus.');
        }

        Facility::query()->whereIn('id', $data['ids'])->update(['is_active' => $data['action'] === 'aktif']);

        return back()->with('success', count($data['ids']).' fasilitas diperbarui.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'group' => ['required', 'in:umum,pendidikan'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);
    }
}
