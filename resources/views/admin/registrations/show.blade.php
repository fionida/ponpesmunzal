@extends('layouts.admin', ['title' => 'Detail Pendaftaran', 'heading' => $item->nama])

@section('content')
<div class="mx-auto grid max-w-4xl gap-6 lg:grid-cols-[1.2fr_.8fr]">
    <section class="metro-card p-6">
        <dl class="space-y-4 text-sm">
            <div><dt class="text-muted">Nama calon santri</dt><dd class="mt-1 font-semibold text-[#252f4a]">{{ $item->nama }}</dd></div>
            <div><dt class="text-muted">TTL</dt><dd class="mt-1">{{ $item->ttl }}</dd></div>
            <div><dt class="text-muted">Nama wali</dt><dd class="mt-1">{{ $item->wali }}</dd></div>
            <div><dt class="text-muted">WhatsApp</dt><dd class="mt-1"><a class="text-forest underline" href="https://wa.me/{{ preg_replace('/\D/', '', $item->whatsapp) }}" target="_blank">{{ $item->whatsapp }}</a></dd></div>
            <div><dt class="text-muted">Program</dt><dd class="mt-1">{{ $item->program }}</dd></div>
            <div><dt class="text-muted">Dikirim</dt><dd class="mt-1">{{ $item->created_at->format('d M Y H:i') }}</dd></div>
        </dl>
    </section>

    <section class="metro-card p-6">
        <h2 class="mb-4 font-semibold text-[#252f4a]">Ubah status</h2>
        <form method="POST" action="{{ route('admin.pendaftaran.update', $item) }}" class="space-y-4">
            @csrf @method('PUT')
            <label class="block text-sm">
                <span class="mb-1.5 block font-medium">Status</span>
                <select name="status" class="metro-input">
                    @foreach (['baru','diproses','diterima','ditolak'] as $st)
                        <option value="{{ $st }}" @selected($item->status === $st)>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block text-sm">
                <span class="mb-1.5 block font-medium">Catatan internal</span>
                <textarea name="notes" rows="4" class="metro-input">{{ old('notes', $item->notes) }}</textarea>
            </label>
            <button class="metro-btn w-full">Simpan</button>
        </form>
        <form method="POST" action="{{ route('admin.pendaftaran.destroy', $item) }}" class="mt-4" onsubmit="return confirm('Hapus data ini?')">
            @csrf @method('DELETE')
            <button class="w-full rounded-full border border-red-200 py-2 text-sm text-red-600">Hapus</button>
        </form>
        <a href="{{ route('admin.pendaftaran.index') }}" class="mt-4 inline-block text-sm text-muted">← Kembali</a>
    </section>
</div>
@endsection
