@extends('layouts.admin', ['title' => $item->exists ? 'Edit Program' : 'Tambah Program', 'heading' => $item->exists ? 'Edit Program' : 'Tambah Program'])
@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.program.update',$item) : route('admin.program.store') }}" class="metro-card mx-auto max-w-2xl space-y-4 p-6">
@csrf @if($item->exists) @method('PUT') @endif
<label class="block text-sm"><span class="mb-1.5 block font-medium">Judul</span><input name="title" value="{{ old('title',$item->title) }}" required class="metro-input"></label>
<label class="block text-sm"><span class="mb-1.5 block font-medium">Deskripsi</span><textarea name="description" rows="3" class="metro-input">{{ old('description',$item->description) }}</textarea></label>
<div class="grid gap-4 sm:grid-cols-2">
<label class="block text-sm"><span class="mb-1.5 block font-medium">Urutan</span><input type="number" name="sort_order" value="{{ old('sort_order',$item->sort_order ?? 0) }}" class="metro-input"></label>
<label class="mt-7 flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$item->is_active ?? true))> Aktif</label>
</div>
<label class="block text-sm"><span class="mb-1.5 block font-medium">Gambar</span><input type="file" name="image" accept="image/*" class="metro-input">@if($item->image)<img src="{{ $item->imageUrl() }}" class="mt-2 h-28 rounded-xl object-cover">@endif</label>
@if($errors->any())<p class="text-sm text-red-600">{{ $errors->first() }}</p>@endif
<div class="flex gap-3"><button class="metro-btn">Simpan</button><a href="{{ route('admin.program.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-semibold text-[#78829d]">Batal</a></div>
</form>
@endsection
