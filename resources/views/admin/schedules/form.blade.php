@extends('layouts.admin', ['title' => $item->exists ? 'Edit Jadwal' : 'Tambah Jadwal', 'heading' => $item->exists ? 'Edit Jadwal' : 'Tambah Jadwal'])
@section('content')
<form method="POST" action="{{ $item->exists ? route('admin.jadwal.update',$item) : route('admin.jadwal.store') }}" class="metro-card mx-auto max-w-xl space-y-4 p-6">
@csrf @if($item->exists) @method('PUT') @endif
<label class="block text-sm"><span class="mb-1.5 block font-medium">Waktu</span><input name="time" value="{{ old('time',$item->time) }}" required class="metro-input" placeholder="03.30"></label>
<label class="block text-sm"><span class="mb-1.5 block font-medium">Kegiatan</span><input name="activity" value="{{ old('activity',$item->activity) }}" required class="metro-input"></label>
<div class="grid gap-4 sm:grid-cols-2">
<label class="block text-sm"><span class="mb-1.5 block font-medium">Urutan</span><input type="number" name="sort_order" value="{{ old('sort_order',$item->sort_order??0) }}" class="metro-input"></label>
<label class="mt-7 flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$item->is_active??true))> Aktif</label>
</div>
<div class="flex gap-3"><button class="metro-btn">Simpan</button><a href="{{ route('admin.jadwal.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-semibold text-[#78829d]">Batal</a></div>
</form>
@endsection
