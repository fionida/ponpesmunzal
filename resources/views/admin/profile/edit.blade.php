@extends('layouts.admin', ['title' => 'Profil Pondok', 'heading' => 'Profil Pondok', 'subtitle' => 'Data yang tampil di halaman publik'])

@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.profil.update') }}" class="space-y-6">
    @csrf @method('PUT')

    <section class="metro-card p-6">
        <h2 class="mb-4 font-semibold text-forest">Identitas</h2>
        <div class="grid gap-4 sm:grid-cols-2">
            <label class="block text-sm sm:col-span-2">
                <span class="mb-1.5 block font-medium">Nama pondok</span>
                <input name="name" value="{{ old('name', $profile->name) }}" required class="metro-input">
            </label>
            <label class="block text-sm">
                <span class="mb-1.5 block font-medium">Tagline</span>
                <input name="tagline" value="{{ old('tagline', $profile->tagline) }}" class="metro-input">
            </label>
            <label class="block text-sm">
                <span class="mb-1.5 block font-medium">Motto</span>
                <input name="motto" value="{{ old('motto', $profile->motto) }}" class="metro-input">
            </label>
            <label class="block text-sm sm:col-span-2">
                <span class="mb-1.5 block font-medium">Sekilas profil</span>
                <textarea name="about" rows="4" class="metro-input">{{ old('about', $profile->about) }}</textarea>
            </label>
            <label class="block text-sm sm:col-span-2">
                <span class="mb-1.5 block font-medium">Sejarah singkat</span>
                <textarea name="history" rows="4" class="metro-input">{{ old('history', $profile->history) }}</textarea>
            </label>
        </div>
    </section>

    <section class="metro-card p-6">
        <h2 class="mb-4 font-semibold text-forest">Visi, Misi & Tujuan</h2>
        <div class="space-y-4">
            <label class="block text-sm">
                <span class="mb-1.5 block font-medium">Visi</span>
                <textarea name="vision" rows="3" class="metro-input">{{ old('vision', $profile->vision) }}</textarea>
            </label>
            <label class="block text-sm">
                <span class="mb-1.5 block font-medium">Misi (satu baris per poin)</span>
                <textarea name="mission" rows="4" class="metro-input">{{ old('mission', $profile->mission) }}</textarea>
            </label>
            <label class="block text-sm">
                <span class="mb-1.5 block font-medium">Tujuan (satu baris per poin)</span>
                <textarea name="goals" rows="4" class="metro-input">{{ old('goals', $profile->goals) }}</textarea>
            </label>
        </div>
    </section>

    <section class="metro-card p-6">
        <h2 class="mb-4 font-semibold text-forest">Pengasuh</h2>
        <div class="grid gap-4 sm:grid-cols-2">
            <label class="block text-sm">
                <span class="mb-1.5 block font-medium">Nama</span>
                <input name="pengasuh_name" value="{{ old('pengasuh_name', $profile->pengasuh_name) }}" class="metro-input">
            </label>
            <label class="block text-sm">
                <span class="mb-1.5 block font-medium">Jabatan</span>
                <input name="pengasuh_title" value="{{ old('pengasuh_title', $profile->pengasuh_title) }}" class="metro-input">
            </label>
            <label class="block text-sm sm:col-span-2">
                <span class="mb-1.5 block font-medium">Bio singkat</span>
                <textarea name="pengasuh_bio" rows="3" class="metro-input">{{ old('pengasuh_bio', $profile->pengasuh_bio) }}</textarea>
            </label>
            <label class="block text-sm">
                <span class="mb-1.5 block font-medium">Foto pengasuh</span>
                <input type="file" name="pengasuh_photo" accept="image/*" class="metro-input">
                <img src="{{ $profile->pengasuhPhotoUrl() }}" class="mt-2 h-28 w-28 rounded-2xl object-cover" alt="">
            </label>
        </div>
    </section>

    <section class="metro-card p-6">
        <h2 class="mb-4 font-semibold text-forest">Kontak & Statistik</h2>
        <div class="grid gap-4 sm:grid-cols-2">
            <label class="block text-sm sm:col-span-2">
                <span class="mb-1.5 block font-medium">Alamat</span>
                <input name="address" value="{{ old('address', $profile->address) }}" class="metro-input">
            </label>
            <label class="block text-sm"><span class="mb-1.5 block font-medium">Telepon</span><input name="phone" value="{{ old('phone', $profile->phone) }}" class="metro-input"></label>
            <label class="block text-sm"><span class="mb-1.5 block font-medium">WhatsApp</span><input name="whatsapp" value="{{ old('whatsapp', $profile->whatsapp) }}" class="metro-input"></label>
            <label class="block text-sm"><span class="mb-1.5 block font-medium">Email</span><input type="email" name="email" value="{{ old('email', $profile->email) }}" class="metro-input"></label>
            <label class="block text-sm"><span class="mb-1.5 block font-medium">Jam operasional</span><input name="hours" value="{{ old('hours', $profile->hours) }}" class="metro-input"></label>
            <label class="block text-sm"><span class="mb-1.5 block font-medium">Stat tahun</span><input name="stat_years" value="{{ old('stat_years', $profile->stat_years) }}" class="metro-input"></label>
            <label class="block text-sm"><span class="mb-1.5 block font-medium">Stat santri</span><input name="stat_students" value="{{ old('stat_students', $profile->stat_students) }}" class="metro-input"></label>
            <label class="block text-sm"><span class="mb-1.5 block font-medium">Stat pengajar</span><input name="stat_teachers" value="{{ old('stat_teachers', $profile->stat_teachers) }}" class="metro-input"></label>
            <label class="block text-sm"><span class="mb-1.5 block font-medium">Stat alumni</span><input name="stat_alumni" value="{{ old('stat_alumni', $profile->stat_alumni) }}" class="metro-input"></label>
            <label class="block text-sm"><span class="mb-1.5 block font-medium">YouTube</span><input name="youtube" value="{{ old('youtube', $profile->youtube) }}" class="metro-input"></label>
            <label class="block text-sm"><span class="mb-1.5 block font-medium">Facebook</span><input name="facebook" value="{{ old('facebook', $profile->facebook) }}" class="metro-input"></label>
            <label class="block text-sm"><span class="mb-1.5 block font-medium">Instagram</span><input name="instagram" value="{{ old('instagram', $profile->instagram) }}" class="metro-input"></label>
            <label class="block text-sm"><span class="mb-1.5 block font-medium">TikTok</span><input name="tiktok" value="{{ old('tiktok', $profile->tiktok) }}" class="metro-input"></label>
            <label class="block text-sm sm:col-span-2"><span class="mb-1.5 block font-medium">URL Embed Google Maps</span><input name="map_embed" value="{{ old('map_embed', $profile->map_embed) }}" class="metro-input" placeholder="https://maps.google.com/maps?q=...&output=embed"></label>
        </div>
    </section>

    <section class="metro-card p-6">
        <h2 class="mb-4 font-semibold text-[#252f4a]">Fitur & Pendaftaran</h2>
        <div class="space-y-4">
            <label class="block text-sm">
                <span class="mb-1.5 block font-medium">Fitur lingkungan (satu baris per item)</span>
                <textarea name="features" rows="4" class="metro-input" placeholder="Asrama Nyaman">{{ old('features', $profile->features) }}</textarea>
            </label>
            <label class="block text-sm">
                <span class="mb-1.5 block font-medium">Dokumen pendaftaran (satu baris per item)</span>
                <textarea name="registration_docs" rows="4" class="metro-input">{{ old('registration_docs', $profile->registration_docs) }}</textarea>
            </label>
            <label class="block text-sm">
                <span class="mb-1.5 block font-medium">Opsi program di form pendaftaran (satu baris per opsi)</span>
                <textarea name="registration_programs" rows="4" class="metro-input">{{ old('registration_programs', $profile->registration_programs) }}</textarea>
            </label>
        </div>
    </section>

    @if ($errors->any())
        <div class="rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
    @endif

    <button class="metro-btn">Simpan Profil</button>
</form>
@endsection
