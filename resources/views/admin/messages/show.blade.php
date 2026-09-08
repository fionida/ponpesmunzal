@extends('layouts.admin', ['title' => 'Detail Pesan', 'heading' => $message->subjek])

@section('content')
<div class="mx-auto max-w-2xl metro-card p-6">
    <dl class="space-y-3 text-sm">
        <div><dt class="text-muted">Dari</dt><dd class="font-semibold">{{ $message->nama }}</dd></div>
        <div><dt class="text-muted">Email</dt><dd>{{ $message->email }}</dd></div>
        <div><dt class="text-muted">WhatsApp</dt><dd>{{ $message->whatsapp }}</dd></div>
        <div><dt class="text-muted">Dikirim</dt><dd>{{ $message->created_at->format('d M Y H:i') }}</dd></div>
        <div><dt class="text-muted">Pesan</dt><dd class="mt-1 whitespace-pre-line rounded-xl bg-[#f5f8fa] p-4">{{ $message->pesan }}</dd></div>
    </dl>
    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.pesan.index') }}" class="text-sm text-muted">← Kembali</a>
        <form method="POST" action="{{ route('admin.pesan.destroy', $message) }}" onsubmit="return confirm('Hapus pesan?')">
            @csrf @method('DELETE')
            <button class="text-sm text-red-600">Hapus</button>
        </form>
    </div>
</div>
@endsection
