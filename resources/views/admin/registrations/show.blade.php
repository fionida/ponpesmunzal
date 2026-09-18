@extends('layouts.admin', ['title' => 'Detail Pendaftaran', 'heading' => 'Detail Pendaftaran', 'subtitle' => $item->nama])

@section('content')
@if (session('success'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('admin.pendaftaran.update', $item) }}" class="space-y-5">
    @csrf @method('PUT')

    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.pendaftaran.index') }}" class="text-sm text-[#78829d] hover:text-[#1b84ff]">← Kembali ke daftar</a>
        @php
            $statusColors = [
                'baru' => 'bg-[#eef6ff] text-[#1b84ff]',
                'diproses' => 'bg-[#fff8dd] text-[#c59a00]',
                'diterima' => 'bg-[#e8fff3] text-[#17c653]',
                'ditolak' => 'bg-[#fff5f8] text-[#f8285a]',
            ];
        @endphp
        <span class="metro-badge {{ $statusColors[$item->status] ?? 'bg-[#f9f9f9] text-[#78829d]' }}">{{ ucfirst($item->status) }}</span>
    </div>

    <div class="grid gap-5 xl:grid-cols-[1.4fr_.9fr]">
        <div class="space-y-5">
            <section class="metro-card overflow-hidden">
                <div class="border-b border-[#eff2f5] bg-[#f9f9f9] px-5 py-3">
                    <h2 class="font-semibold">Data Calon Santri</h2>
                </div>
                <div class="grid gap-4 p-5 sm:grid-cols-2">
                    <label class="block text-sm sm:col-span-2">
                        <span class="mb-1.5 block font-medium">Nama Lengkap</span>
                        <input name="nama" value="{{ old('nama', $item->nama) }}" required class="metro-input">
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Jenis Kelamin</span>
                        <select name="jenis_kelamin" class="metro-input">
                            <option value="">—</option>
                            <option value="Laki-laki" @selected(old('jenis_kelamin', $item->jenis_kelamin) === 'Laki-laki')>Laki-laki</option>
                            <option value="Perempuan" @selected(old('jenis_kelamin', $item->jenis_kelamin) === 'Perempuan')>Perempuan</option>
                        </select>
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Sekolah Asal</span>
                        <input name="sekolah_asal" value="{{ old('sekolah_asal', $item->sekolah_asal) }}" class="metro-input">
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Tempat Lahir</span>
                        <input name="tempat_lahir" value="{{ old('tempat_lahir', $item->tempat_lahir) }}" class="metro-input">
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Tanggal Lahir</span>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($item->tanggal_lahir)->format('Y-m-d')) }}" class="metro-input">
                    </label>
                    <label class="block text-sm sm:col-span-2">
                        <span class="mb-1.5 block font-medium">Alamat</span>
                        <textarea name="alamat" rows="3" class="metro-input">{{ old('alamat', $item->alamat) }}</textarea>
                    </label>
                    @if ($item->ttl && ! $item->tempat_lahir)
                        <p class="sm:col-span-2 text-xs text-[#78829d]">TTL lama (teks): {{ $item->ttl }}</p>
                    @endif
                </div>
            </section>

            <section class="metro-card overflow-hidden">
                <div class="border-b border-[#eff2f5] bg-[#f9f9f9] px-5 py-3">
                    <h2 class="font-semibold">Data Wali</h2>
                </div>
                <div class="grid gap-4 p-5 sm:grid-cols-2">
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Nama Wali</span>
                        <input name="wali" value="{{ old('wali', $item->wali) }}" required class="metro-input">
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Hubungan</span>
                        <select name="hubungan_wali" class="metro-input">
                            <option value="">—</option>
                            @foreach (['Ayah', 'Ibu', 'Wali', 'Kakak', 'Lainnya'] as $rel)
                                <option value="{{ $rel }}" @selected(old('hubungan_wali', $item->hubungan_wali) === $rel)>{{ $rel }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">WhatsApp</span>
                        <input name="whatsapp" value="{{ old('whatsapp', $item->whatsapp) }}" required class="metro-input">
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Email</span>
                        <input type="email" name="email_wali" value="{{ old('email_wali', $item->email_wali) }}" class="metro-input">
                    </label>
                </div>
            </section>

            <section class="metro-card overflow-hidden">
                <div class="border-b border-[#eff2f5] bg-[#f9f9f9] px-5 py-3">
                    <h2 class="font-semibold">Program & Catatan Pendaftar</h2>
                </div>
                <div class="space-y-4 p-5">
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Program</span>
                        <input name="program" value="{{ old('program', $item->program) }}" required class="metro-input">
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Catatan dari pendaftar</span>
                        <textarea name="catatan" rows="3" class="metro-input">{{ old('catatan', $item->catatan) }}</textarea>
                    </label>
                </div>
            </section>
        </div>

        <div class="space-y-5">
            <section class="metro-card overflow-hidden">
                <div class="border-b border-[#eff2f5] bg-[#f9f9f9] px-5 py-3">
                    <h2 class="font-semibold">Ringkasan</h2>
                </div>
                <dl class="space-y-3 p-5 text-sm">
                    <div class="flex justify-between gap-3 border-b border-[#eff2f5] pb-3">
                        <dt class="text-[#78829d]">TTL</dt>
                        <dd class="text-right font-medium">{{ $item->ttlDisplay() }}</dd>
                    </div>
                    <div class="flex justify-between gap-3 border-b border-[#eff2f5] pb-3">
                        <dt class="text-[#78829d]">WhatsApp</dt>
                        <dd class="text-right">
                            <a class="font-medium text-[#1b84ff]" href="https://wa.me/{{ preg_replace('/\D/', '', $item->whatsapp) }}" target="_blank">{{ $item->whatsapp }}</a>
                        </dd>
                    </div>
                    <div class="flex justify-between gap-3 border-b border-[#eff2f5] pb-3">
                        <dt class="text-[#78829d]">Masuk</dt>
                        <dd class="text-right font-medium">{{ $item->created_at->format('d M Y H:i') }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-[#78829d]">Diperbarui</dt>
                        <dd class="text-right font-medium">{{ $item->updated_at->format('d M Y H:i') }}</dd>
                    </div>
                </dl>
            </section>

            <section class="metro-card overflow-hidden">
                <div class="border-b border-[#eff2f5] bg-[#f9f9f9] px-5 py-3">
                    <h2 class="font-semibold">Status & Catatan Internal</h2>
                </div>
                <div class="space-y-4 p-5">
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Status</span>
                        <select name="status" class="metro-input">
                            @foreach (['baru' => 'Baru', 'diproses' => 'Diproses', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $item->status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Catatan internal</span>
                        <textarea name="notes" rows="5" class="metro-input" placeholder="Hanya terlihat di admin">{{ old('notes', $item->notes) }}</textarea>
                    </label>
                    <button class="metro-btn w-full">Simpan Perubahan</button>
                </div>
            </section>
        </div>
    </div>
</form>

<form method="POST" action="{{ route('admin.pendaftaran.destroy', $item) }}" class="mt-5 max-w-sm xl:ml-auto" onsubmit="return confirm('Hapus data pendaftaran ini?')">
    @csrf @method('DELETE')
    <button class="w-full rounded-xl border border-red-200 bg-white py-2.5 text-sm font-medium text-red-600 hover:bg-red-50">Hapus Pendaftaran</button>
</form>
@endsection
