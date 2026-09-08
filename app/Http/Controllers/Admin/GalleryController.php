<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $items = Gallery::query()
            ->when($request->type, fn ($q, $type) => $q->where('type', $type))
            ->when($request->category, fn ($q, $category) => $q->where('category', $category))
            ->when($request->q, fn ($q, $search) => $q->where('title', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.galleries.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.galleries.form', ['item' => new Gallery]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image'] = $this->storeImage($request);
        $data['is_featured'] = $request->boolean('is_featured');

        Gallery::query()->create($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Item galeri ditambahkan.');
    }

    public function edit(Gallery $galeri): View
    {
        return view('admin.galleries.form', ['item' => $galeri]);
    }

    public function update(Request $request, Gallery $galeri): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($galeri->image) {
                Storage::disk('public')->delete($galeri->image);
            }
            $data['image'] = $this->storeImage($request);
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Item galeri diperbarui.');
    }

    public function destroy(Gallery $galeri): RedirectResponse
    {
        if ($galeri->image) {
            Storage::disk('public')->delete($galeri->image);
        }
        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Item galeri dihapus.');
    }

    public function bulk(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:galleries,id'],
            'action' => ['required', 'in:delete,feature,unfeature'],
        ]);

        if ($data['action'] === 'delete') {
            $items = Gallery::query()->whereIn('id', $data['ids'])->get();
            foreach ($items as $item) {
                if ($item->image) {
                    Storage::disk('public')->delete($item->image);
                }
                $item->delete();
            }

            return back()->with('success', count($data['ids']).' item galeri dihapus.');
        }

        Gallery::query()->whereIn('id', $data['ids'])->update([
            'is_featured' => $data['action'] === 'feature',
        ]);

        return back()->with('success', count($data['ids']).' item diperbarui.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'category' => ['required', 'string', 'max:80'],
            'type' => ['required', 'in:foto,video'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'duration' => ['nullable', 'string', 'max:20'],
            'taken_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);
    }

    private function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        return $request->file('image')->store('galeri', 'public');
    }
}
