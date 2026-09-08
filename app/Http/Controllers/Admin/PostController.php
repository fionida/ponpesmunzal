<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::query()
            ->when($request->q, fn ($q, $search) => $q->where('title', 'like', "%{$search}%"))
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.posts.form', ['post' => new Post]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['cover'] = $this->storeCover($request);
        $data['published_at'] = $data['status'] === 'published'
            ? ($request->published_at ?: now())
            : null;

        Post::query()->create($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.form', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validated($request);
        if ($request->hasFile('cover')) {
            if ($post->cover) {
                Storage::disk('public')->delete($post->cover);
            }
            $data['cover'] = $this->storeCover($request);
        }

        if ($data['status'] === 'published') {
            $data['published_at'] = $request->published_at ?: ($post->published_at ?? now());
        } else {
            $data['published_at'] = null;
        }

        $post->update($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->cover) {
            Storage::disk('public')->delete($post->cover);
        }
        $post->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita dihapus.');
    }

    public function bulk(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:posts,id'],
            'action' => ['required', 'in:delete,publish,draft'],
        ]);

        $posts = Post::query()->whereIn('id', $data['ids'])->get();

        if ($data['action'] === 'delete') {
            foreach ($posts as $post) {
                if ($post->cover) {
                    Storage::disk('public')->delete($post->cover);
                }
                $post->delete();
            }

            return back()->with('success', count($data['ids']).' berita dihapus.');
        }

        if ($data['action'] === 'publish') {
            Post::query()->whereIn('id', $data['ids'])->update([
                'status' => 'published',
                'published_at' => now(),
            ]);

            return back()->with('success', count($data['ids']).' berita dipublish.');
        }

        Post::query()->whereIn('id', $data['ids'])->update([
            'status' => 'draft',
            'published_at' => null,
        ]);

        return back()->with('success', count($data['ids']).' berita dijadikan draft.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'category' => ['required', 'string', 'max:60'],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'body' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
            'cover' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    private function storeCover(Request $request): ?string
    {
        if (! $request->hasFile('cover')) {
            return null;
        }

        return $request->file('cover')->store('berita', 'public');
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;
        while (Post::query()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
