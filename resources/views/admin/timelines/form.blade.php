@extends('layouts.admin', ['title' => $item->exists ? 'Edit Timeline' : 'Tambah Timeline', 'heading' => $item->exists ? 'Edit Timeline' : 'Tambah Timeline'])
@section('content')
<form method="POST" action="{{ $item->exists ? route('admin.timeline.update',$item) : route('admin.timeline.store') }}" class="metro-card mx-auto max-w-xl space-y-4 p-6">
@csrf @if($item->exists) @method('PUT') @endif
<label class="block text-sm"><span class="mb-1.5 block font-medium">Tahun</span><input name="year" value="{{ old('year',$item->year) }}" required class="metro-input" placeholder="2004"></label>
<label class="block text-sm"><span class="mb-1.5 block font-medium">Keterangan</span><input name="title" value="{{ old('title',$item->title) }}" required class="metro-input"></label>
<div class="grid gap-4 sm:grid-cols-2">
<label class="block text-sm"><span class="mb-1.5 block font-medium">Urutan</span><input type="number" name="sort_order" value="{{ old('sort_order',$item->sort_order??0) }}" class="metro-input"></label>
<label class="mt-7 flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$item->is_active??true))> Aktif</label>
</div>
<div class="flex gap-3"><button class="metro-btn">Simpan</button><a href="{{ route('admin.timeline.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-semibold text-[#78829d]">Batal</a></div>
</form>
@endsection
