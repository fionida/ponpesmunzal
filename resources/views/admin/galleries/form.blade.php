@extends('layouts.admin', [
    'title' => $item->exists ? 'Edit Galeri' : 'Tambah Galeri',
    'heading' => $item->exists ? 'Edit Galeri' : 'Tambah Galeri',
])

@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.galeri.update', $item) : route('admin.galeri.store') }}" class="metro-card mx-auto max-w-2xl space-y-5 p-6 lg:p-8">
    @csrf
    @if ($item->exists) @method('PUT') @endif

    <label class="block text-sm">
        <span class="mb-1.5 block font-medium">Judul</span>
        <input name="title" value="{{ old('title', $item->title) }}" required class="metro-input">
    </label>

    <div class="grid gap-4 sm:grid-cols-2">
        <label class="block text-sm">
            <span class="mb-1.5 block font-medium">Kategori</span>
            <select name="category" class="metro-input">
                @foreach (['Kegiatan Harian','Kegiatan Keagamaan','Kegiatan Akademik','Ekstrakurikuler','Sarana & Prasarana','Kunjungan Tamu','Prestasi'] as $cat)
                    <option value="{{ $cat }}" @selected(old('category', $item->category ?? 'Kegiatan Harian') === $cat)>{{ $cat }}</option>
                @endforeach
            </select>
        </label>
        <label class="block text-sm">
            <span class="mb-1.5 block font-medium">Tipe</span>
            <select name="type" class="metro-input">
                <option value="foto" @selected(old('type', $item->type ?? 'foto') === 'foto')>Foto</option>
                <option value="video" @selected(old('type', $item->type) === 'video')>Video</option>
            </select>
        </label>
    </div>

    <label class="block text-sm">
        <span class="mb-1.5 block font-medium">Gambar / thumbnail</span>
        <input type="file" name="image" accept="image/*" class="metro-input">
        @if ($item->image)
            <img src="{{ $item->imageUrl() }}" class="mt-2 h-32 rounded-xl object-cover" alt="">
        @endif
    </label>

    <div class="grid gap-4 sm:grid-cols-2">
        <label class="block text-sm">
            <span class="mb-1.5 block font-medium">URL Video (opsional)</span>
            <input type="url" name="video_url" value="{{ old('video_url', $item->video_url) }}" class="metro-input" placeholder="https://youtube.com/...">
        </label>
        <label class="block text-sm">
            <span class="mb-1.5 block font-medium">Durasi</span>
            <input name="duration" value="{{ old('duration', $item->duration) }}" class="metro-input" placeholder="04:32">
        </label>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <label class="block text-sm">
            <span class="mb-1.5 block font-medium">Tanggal</span>
            <input type="date" name="taken_at" value="{{ old('taken_at', optional($item->taken_at)->format('Y-m-d')) }}" class="metro-input">
        </label>
        <label class="mt-7 flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $item->is_featured)) class="rounded border-gray-300 text-[#1b84ff]">
            Tampilkan sebagai unggulan
        </label>
    </div>

    @if ($errors->any())
        <div class="rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
    @endif

    <div class="flex gap-3">
        <button class="metro-btn">Simpan</button>
        <a href="{{ route('admin.galeri.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-semibold text-[#78829d] hover:bg-[#f5f8fa]">Batal</a>
    </div>
</form>
@endsection
