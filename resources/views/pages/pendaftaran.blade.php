@extends('layouts.app', ['title' => 'Pendaftaran'])

@section('content')
@include('partials.page-hero', [
    'image' => $img['students'],
    'crumb' => 'Pendaftaran',
    'heading' => $contents['pendaftaran.hero_title'] ?? 'Pendaftaran Santri Baru',
    'text' => $contents['pendaftaran.hero_text'] ?? 'Isi formulir awal. Panitia akan menghubungi wali untuk langkah berikutnya.',
    'quote' => $contents['pendaftaran.quote'] ?? 'Tuntutlah ilmu dari buaian hingga liang lahat.',
    'quoteBy' => $contents['pendaftaran.quote_by'] ?? 'Hadis',
])

<section class="py-16">
    <div class="container-site grid items-start gap-10 lg:grid-cols-[1.15fr_.85fr]">
        <div>
            <h2 class="font-serif text-3xl font-semibold">{{ $contents['pendaftaran.form_title'] ?? 'Formulir Pendaftaran Awal' }}</h2>
            <p class="mt-2 text-sm text-muted">{{ $contents['pendaftaran.form_text'] ?? 'Lengkapi data calon santri. Tidak perlu akun. Proses ini hanya pendaftaran awal.' }}</p>
            @if (session('success'))
                <p class="mt-4 rounded-xl bg-sand px-4 py-3 text-sm text-forest">{{ session('success') }}</p>
            @endif
            @if ($errors->any())
                <p class="mt-4 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-600">{{ $errors->first() }}</p>
            @endif

            <form action="{{ route('pendaftaran.submit') }}" method="POST" class="mt-8 space-y-8">
                @csrf

                <fieldset class="space-y-4">
                    <legend class="mb-1 font-serif text-xl font-semibold text-forest">Data Calon Santri</legend>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block text-sm sm:col-span-2">
                            <span class="mb-1.5 block font-medium">Nama Lengkap</span>
                            <input name="nama" value="{{ old('nama') }}" required class="input-field" placeholder="Nama sesuai akta">
                        </label>
                        <label class="block text-sm">
                            <span class="mb-1.5 block font-medium">Jenis Kelamin</span>
                            <select name="jenis_kelamin" required class="input-field">
                                <option value="">Pilih</option>
                                <option value="Laki-laki" @selected(old('jenis_kelamin') === 'Laki-laki')>Laki-laki</option>
                                <option value="Perempuan" @selected(old('jenis_kelamin') === 'Perempuan')>Perempuan</option>
                            </select>
                        </label>
                        <label class="block text-sm">
                            <span class="mb-1.5 block font-medium">Sekolah Asal</span>
                            <input name="sekolah_asal" value="{{ old('sekolah_asal') }}" class="input-field" placeholder="Opsional">
                        </label>
                        <label class="block text-sm">
                            <span class="mb-1.5 block font-medium">Tempat Lahir</span>
                            <input name="tempat_lahir" value="{{ old('tempat_lahir') }}" required class="input-field" placeholder="Malang">
                        </label>
                        <label class="block text-sm">
                            <span class="mb-1.5 block font-medium">Tanggal Lahir</span>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="input-field">
                        </label>
                        <label class="block text-sm sm:col-span-2">
                            <span class="mb-1.5 block font-medium">Alamat Lengkap</span>
                            <textarea name="alamat" rows="3" required class="input-field" placeholder="Jalan, desa/kelurahan, kecamatan, kota">{{ old('alamat') }}</textarea>
                        </label>
                    </div>
                </fieldset>

                <fieldset class="space-y-4 border-t border-black/5 pt-8">
                    <legend class="mb-1 font-serif text-xl font-semibold text-forest">Data Wali</legend>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block text-sm">
                            <span class="mb-1.5 block font-medium">Nama Wali</span>
                            <input name="wali" value="{{ old('wali') }}" required class="input-field">
                        </label>
                        <label class="block text-sm">
                            <span class="mb-1.5 block font-medium">Hubungan dengan Santri</span>
                            <select name="hubungan_wali" required class="input-field">
                                @foreach (['Ayah', 'Ibu', 'Wali', 'Kakak', 'Lainnya'] as $rel)
                                    <option value="{{ $rel }}" @selected(old('hubungan_wali') === $rel)>{{ $rel }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block text-sm">
                            <span class="mb-1.5 block font-medium">WhatsApp Wali</span>
                            <input name="whatsapp" value="{{ old('whatsapp') }}" required class="input-field" placeholder="08xx">
                        </label>
                        <label class="block text-sm">
                            <span class="mb-1.5 block font-medium">Email Wali</span>
                            <input type="email" name="email_wali" value="{{ old('email_wali') }}" class="input-field" placeholder="Opsional">
                        </label>
                    </div>
                </fieldset>

                <fieldset class="space-y-4 border-t border-black/5 pt-8">
                    <legend class="mb-1 font-serif text-xl font-semibold text-forest">Program & Catatan</legend>
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Program yang Diminati</span>
                        <select name="program" required class="input-field">
                            @foreach (preg_split('/\r\n|\r|\n/', $profile->registration_programs ?: "Tahfidz Al-Qur’an\nMadrasah Diniyah\nPendidikan Formal\nKombinasi (Tahfidz + Formal)") as $opt)
                                @if (trim($opt) !== '')
                                    <option {{ old('program') === trim($opt) ? 'selected' : '' }}>{{ trim($opt) }}</option>
                                @endif
                            @endforeach
                        </select>
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Catatan (opsional)</span>
                        <textarea name="catatan" rows="3" class="input-field" placeholder="Informasi tambahan untuk panitia">{{ old('catatan') }}</textarea>
                    </label>
                </fieldset>

                <button class="btn-gold">Kirim Pendaftaran →</button>
            </form>
        </div>

        <aside class="space-y-4 lg:sticky lg:top-24">
            <div class="rounded-3xl bg-forest p-7 text-white">
                <h3 class="font-serif text-2xl font-semibold">{{ $contents['pendaftaran.docs_title'] ?? 'Yang perlu disiapkan' }}</h3>
                <ul class="mt-4 space-y-2 text-sm text-white/80">
                    @foreach (preg_split('/\r\n|\r|\n/', $profile->registration_docs ?: "Fotokopi KK dan akta kelahiran\nPas foto 3x4\nRapor terakhir\nSurat keterangan sehat") as $doc)
                        @if (trim($doc) !== '')
                            <li class="flex gap-2"><span>•</span><span>{{ trim($doc) }}</span></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="rounded-3xl bg-sand p-7">
                <h3 class="font-semibold text-forest">{{ $contents['pendaftaran.help_title'] ?? 'Butuh bantuan?' }}</h3>
                @php
                    $helpText = $contents['pendaftaran.help_text'] ?? 'Hubungi panitia di {whatsapp} atau {email} pada {hours}.';
                    $helpText = str_replace(
                        ['{whatsapp}', '{email}', '{hours}'],
                        [
                            $profile->whatsapp ?: config('ponpes.whatsapp'),
                            $profile->email ?: config('ponpes.email'),
                            $profile->hours ?: config('ponpes.hours'),
                        ],
                        $helpText
                    );
                @endphp
                <p class="mt-2 text-sm text-muted">{{ $helpText }}</p>
                <a href="{{ route('kontak') }}" class="btn-forest mt-4">Hubungi Kami</a>
            </div>
        </aside>
    </div>
</section>
@endsection
