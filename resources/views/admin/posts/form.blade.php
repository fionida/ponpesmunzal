@extends('layouts.admin', [
    'title' => $post->exists ? 'Edit Berita' : 'Tulis Berita',
    'heading' => $post->exists ? 'Edit Berita' : 'Tulis Berita',
])

@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ $post->exists ? route('admin.berita.update', $post) : route('admin.berita.store') }}" class="metro-card mx-auto max-w-3xl space-y-5 p-6 lg:p-8">
    @csrf
    @if ($post->exists) @method('PUT') @endif

    <label class="block text-sm">
        <span class="mb-1.5 block font-medium">Judul</span>
        <input name="title" value="{{ old('title', $post->title) }}" required class="metro-input">
    </label>

    <div class="grid gap-4 sm:grid-cols-2">
        <label class="block text-sm">
            <span class="mb-1.5 block font-medium">Kategori</span>
            <select name="category" class="metro-input">
                @foreach (['Kegiatan','Akademik','Prestasi','Pengumuman','Artikel','Sosial','Keagamaan','Kesehatan','Liputan Khusus'] as $cat)
                    <option value="{{ $cat }}" @selected(old('category', $post->category ?? 'Kegiatan') === $cat)>{{ $cat }}</option>
                @endforeach
            </select>
        </label>
        <label class="block text-sm">
            <span class="mb-1.5 block font-medium">Status</span>
            <select name="status" class="metro-input">
                <option value="draft" @selected(old('status', $post->status ?? 'draft') === 'draft')>Draft</option>
                <option value="published" @selected(old('status', $post->status) === 'published')>Published</option>
            </select>
        </label>
    </div>

    <label class="block text-sm">
        <span class="mb-1.5 block font-medium">Ringkasan singkat</span>
        <textarea name="excerpt" rows="2" class="metro-input" maxlength="300">{{ old('excerpt', $post->excerpt) }}</textarea>
    </label>

    <label class="block text-sm">
        <span class="mb-1.5 block font-medium">Isi berita</span>
        <textarea name="body" rows="10" class="metro-input">{{ old('body', $post->body) }}</textarea>
    </label>

    <div class="grid gap-4 sm:grid-cols-2">
        <label class="block text-sm">
            <span class="mb-1.5 block font-medium">Cover</span>
            <input type="file" name="cover" accept="image/*" class="metro-input">
            @if ($post->cover)
                <img src="{{ $post->coverUrl() }}" class="mt-2 h-28 rounded-xl object-cover" alt="">
            @endif
        </label>
        <label class="block text-sm">
            <span class="mb-1.5 block font-medium">Tanggal publish</span>
            <input type="datetime-local" name="published_at" class="metro-input" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">
        </label>
    </div>

    @if ($errors->any())
        <div class="rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
    @endif

    <div class="flex gap-3 pt-2">
        <button class="metro-btn">Simpan</button>
        <a href="{{ route('admin.berita.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-semibold text-[#78829d] hover:bg-[#f5f8fa]">Batal</a>
    </div>
</form>
@endsection
