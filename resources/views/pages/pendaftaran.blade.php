@extends('layouts.app', ['title' => 'Pendaftaran'])

@section('content')
@include('partials.page-hero', [
    'image' => $img['students'],
    'crumb' => 'Pendaftaran',
    'heading' => $contents['pendaftaran.hero_title'] ?? 'Pendaftaran Santri Baru',
    'text' => $contents['pendaftaran.hero_text'] ?? 'Isi formulir awal. Panitia akan menghubungi wali untuk langkah berikutnya.',
    'quote' => 'Tuntutlah ilmu dari buaian hingga liang lahat.',
    'quoteBy' => 'Hadis',
])

<section class="py-16">
    <div class="container-site grid items-start gap-10 lg:grid-cols-[1fr_.85fr]">
        <div>
            <h2 class="font-serif text-3xl font-semibold">Formulir Pendaftaran Awal</h2>
            <p class="mt-2 text-sm text-muted">Lengkapi data calon santri. Tidak perlu akun. Proses ini hanya pendaftaran awal.</p>
            @if (session('success'))
                <p class="mt-4 rounded-xl bg-sand px-4 py-3 text-sm text-forest">{{ session('success') }}</p>
            @endif
            <form action="{{ route('pendaftaran.submit') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <label class="block text-sm">
                    <span class="mb-1.5 block font-medium">Nama Calon Santri</span>
                    <input name="nama" value="{{ old('nama') }}" required class="input-field">
                </label>
                <label class="block text-sm">
                    <span class="mb-1.5 block font-medium">Tempat, Tanggal Lahir</span>
                    <input name="ttl" value="{{ old('ttl') }}" required class="input-field" placeholder="Malang, 12 Januari 2012">
                </label>
                <label class="block text-sm">
                    <span class="mb-1.5 block font-medium">Nama Wali</span>
                    <input name="wali" value="{{ old('wali') }}" required class="input-field">
                </label>
                <label class="block text-sm">
                    <span class="mb-1.5 block font-medium">WhatsApp Wali</span>
                    <input name="whatsapp" value="{{ old('whatsapp') }}" required class="input-field">
                </label>
                <label class="block text-sm">
                    <span class="mb-1.5 block font-medium">Program yang Diminati</span>
                    <select name="program" class="input-field">
                        @foreach (preg_split('/\r\n|\r|\n/', $profile->registration_programs ?: "Tahfidz Al-Qur’an\nMadrasah Diniyah\nPendidikan Formal\nKombinasi (Tahfidz + Formal)") as $opt)
                            @if (trim($opt) !== '')
                                <option {{ old('program') === trim($opt) ? 'selected' : '' }}>{{ trim($opt) }}</option>
                            @endif
                        @endforeach
                    </select>
                </label>
                @if ($errors->any())
                    <p class="text-sm text-red-600">{{ $errors->first() }}</p>
                @endif
                <button class="btn-gold">Kirim Pendaftaran →</button>
            </form>
        </div>
        <aside class="space-y-4">
            <div class="rounded-3xl bg-forest p-7 text-white">
                <h3 class="font-serif text-2xl font-semibold">Yang perlu disiapkan</h3>
                <ul class="mt-4 space-y-2 text-sm text-white/80">
                    @foreach (preg_split('/\r\n|\r|\n/', $profile->registration_docs ?: "Fotokopi KK dan akta kelahiran\nPas foto 3x4\nRapor terakhir\nSurat keterangan sehat") as $doc)
                        @if (trim($doc) !== '')
                            <li>{{ trim($doc) }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="rounded-3xl bg-sand p-7">
                <h3 class="font-semibold text-forest">Butuh bantuan?</h3>
                <p class="mt-2 text-sm text-muted">Hubungi panitia di {{ $profile->whatsapp ?: config('ponpes.whatsapp') }} atau {{ $profile->email ?: config('ponpes.email') }} pada {{ $profile->hours ?: config('ponpes.hours') }}.</p>
                <a href="{{ route('kontak') }}" class="btn-forest mt-4">Hubungi Kami</a>
            </div>
        </aside>
    </div>
</section>
@endsection
