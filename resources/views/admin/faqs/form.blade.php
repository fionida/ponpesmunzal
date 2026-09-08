@extends('layouts.admin', ['title' => $item->exists ? 'Edit FAQ' : 'Tambah FAQ', 'heading' => $item->exists ? 'Edit FAQ' : 'Tambah FAQ'])
@section('content')
<form method="POST" action="{{ $item->exists ? route('admin.faq.update',$item) : route('admin.faq.store') }}" class="metro-card mx-auto max-w-2xl space-y-4 p-6">
@csrf @if($item->exists) @method('PUT') @endif
<label class="block text-sm"><span class="mb-1.5 block font-medium">Pertanyaan</span><input name="question" value="{{ old('question',$item->question) }}" required class="metro-input"></label>
<label class="block text-sm"><span class="mb-1.5 block font-medium">Jawaban</span><textarea name="answer" rows="4" required class="metro-input">{{ old('answer',$item->answer) }}</textarea></label>
<div class="grid gap-4 sm:grid-cols-2">
<label class="block text-sm"><span class="mb-1.5 block font-medium">Urutan</span><input type="number" name="sort_order" value="{{ old('sort_order',$item->sort_order??0) }}" class="metro-input"></label>
<label class="mt-7 flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$item->is_active??true))> Aktif</label>
</div>
<div class="flex gap-3"><button class="metro-btn">Simpan</button><a href="{{ route('admin.faq.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-semibold text-[#78829d]">Batal</a></div>
</form>
@endsection
