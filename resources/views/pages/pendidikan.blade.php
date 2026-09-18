@extends('layouts.app', ['title' => 'Pendidikan'])

@section('content')
@include('partials.page-hero', [
    'image' => $img['students'],
    'crumb' => 'Pendidikan',
    'heading' => $contents['pendidikan.hero_title'] ?? 'Pendidikan Menyeluruh untuk Membentuk Generasi Unggul',
    'text' => $contents['pendidikan.hero_text'] ?? 'Kurikulum terpadu yang memadukan tahfidz, diniyah, pendidikan formal, dan pembiasaan bahasa.',
    'quote' => $contents['pendidikan.quote'] ?? 'Menuntut ilmu adalah kewajiban bagi setiap muslim.',
    'quoteArabic' => $contents['pendidikan.quote_ar'] ?? 'طَلَبُ الْعِلْمِ فَرِيضَةٌ',
    'quoteBy' => $contents['pendidikan.quote_by'] ?? 'HR. Ibnu Majah',
])

<section class="relative z-10 -mt-8">
    <div class="container-site grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach (preg_split('/\r\n|\r|\n/', $contents['pendidikan.highlights'] ?? "Kurikulum Terpadu\nPembinaan Karakter\nLingkungan Islami\nTenaga Pengajar Kompeten") as $f)
            @if (trim($f) !== '')
                <div class="card-soft p-5">
                    <div class="mb-3 inline-flex h-11 w-11 items-center justify-center rounded-full bg-sand text-forest">◉</div>
                    <h3 class="font-semibold text-forest">{{ trim($f) }}</h3>
                </div>
            @endif
        @endforeach
    </div>
</section>

<section class="py-16">
    <div class="container-site">
        <div class="mb-8 flex items-end justify-between">
            <div>
                <p class="text-xs font-semibold tracking-[0.18em] text-forest">{{ $contents['pendidikan.programs_eyebrow'] ?? 'PROGRAM PENDIDIKAN' }}</p>
                <h2 class="mt-2 font-serif text-3xl font-semibold">{{ $contents['pendidikan.programs_title'] ?? 'Program Pendidikan' }}</h2>
            </div>
            <a href="{{ route('pendaftaran') }}" class="text-sm font-semibold text-forest">Lihat Semua Program →</a>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-5">
            @forelse (($programs ?? collect()) as $p)
                <article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5">
                    <img src="{{ $p->imageUrl() }}" alt="{{ $p->title }}" class="h-36 w-full object-cover">
                    <div class="p-4">
                        <h3 class="font-serif text-lg font-semibold text-forest">{{ $p->title }}</h3>
                        <p class="mt-2 text-sm text-muted">{{ $p->description }}</p>
                        <a href="{{ route('pendaftaran') }}" class="mt-3 inline-flex text-sm font-semibold text-forest">Selengkapnya →</a>
                    </div>
                </article>
            @empty
                <p class="text-sm text-muted">Belum ada program. Tambahkan lewat admin.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="bg-mist py-16">
    <div class="container-site grid items-center gap-6 lg:grid-cols-[.9fr_.8fr_1fr]">
        <div class="rounded-3xl bg-forest p-8 text-white">
            <p class="text-xs font-semibold tracking-[0.18em] text-gold">KURIKULUM & METODE</p>
            <h2 class="mt-3 font-serif text-3xl font-semibold">{{ $contents['pendidikan.kurikulum_title'] ?? 'Kurikulum Terintegrasi' }}</h2>
            <p class="mt-4 text-sm text-white/80">{{ $contents['pendidikan.kurikulum_text'] ?? 'Setiap hari santri menjalani siklus ibadah, mengaji, kelas formal, dan pembiasaan adab yang saling menopang.' }}</p>
            <a href="{{ route('kontak') }}" class="btn-gold mt-6">Pelajari Kurikulum</a>
        </div>
        <img src="{{ $img['library'] }}" alt="Santri belajar" class="h-[420px] w-full rounded-3xl object-cover">
        <div>
            <h3 class="mb-5 font-serif text-2xl font-semibold">{{ $contents['pendidikan.metode_title'] ?? 'Metode Pembelajaran' }}</h3>
            <div class="space-y-4">
                @foreach (preg_split('/\r\n|\r|\n/', $contents['pendidikan.metode'] ?? "Sorogan & Bandongan|Bimbingan kitab secara personal dan klasikal.\nHalaqah & Diskusi|Melatih pemahaman dan adab berbicara.\nPraktik & Pembiasaan|Ilmu diamalkan dalam kehidupan asrama.\nEvaluasi Berkala|Setoran, ujian, dan rapor perkembangan.") as $line)
                    @php $parts = array_map('trim', explode('|', $line, 2)); @endphp
                    @if (($parts[0] ?? '') !== '')
                        <div class="rounded-2xl bg-white p-4 shadow-sm">
                            <h4 class="font-semibold text-forest">{{ $parts[0] }}</h4>
                            <p class="mt-1 text-sm text-muted">{{ $parts[1] ?? '' }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="py-16">
    <div class="container-site">
        <div class="mb-8 flex items-end justify-between">
            <div>
                <p class="text-xs font-semibold tracking-[0.18em] text-forest">{{ $contents['pendidikan.fasilitas_eyebrow'] ?? 'FASILITAS PENDIDIKAN' }}</p>
                <h2 class="mt-2 font-serif text-3xl font-semibold">{{ $contents['pendidikan.fasilitas_title'] ?? 'Sarana Belajar yang Lengkap' }}</h2>
            </div>
            <a href="{{ route('galeri') }}" class="text-sm font-semibold text-forest">Lihat Semua Fasilitas →</a>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse (($facilities ?? collect()) as $f)
                <article class="flex items-center gap-4 rounded-2xl bg-mist p-3">
                    <img src="{{ $f->imageUrl() }}" alt="{{ $f->title }}" class="h-16 w-20 rounded-xl object-cover">
                    <h3 class="font-semibold text-forest">{{ $f->title }}</h3>
                </article>
            @empty
                <p class="text-sm text-muted">Belum ada fasilitas. Tambahkan lewat admin.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="bg-mist py-16">
    <div class="container-site grid gap-8 lg:grid-cols-3">
        <div>
            <p class="text-xs font-semibold tracking-[0.18em] text-forest">{{ $contents['pendidikan.jadwal_eyebrow'] ?? 'KEGIATAN BELAJAR SANTRI' }}</p>
            <h2 class="mt-2 font-serif text-3xl font-semibold">{{ $contents['pendidikan.jadwal_title'] ?? 'Ritme harian yang membentuk' }}</h2>
            <p class="mt-3 text-sm text-muted">{{ $contents['pendidikan.jadwal_text'] ?? 'Dari tahajud hingga istirahat malam, setiap waktu diisi dengan ibadah, belajar, dan istirahat yang seimbang.' }}</p>
            <div class="mt-5 grid grid-cols-2 gap-3">
                <img src="{{ $img['study'] }}" class="h-28 rounded-xl object-cover" alt="">
                <img src="{{ $img['prayer'] }}" class="h-28 rounded-xl object-cover" alt="">
                <img src="{{ $img['quran'] }}" class="h-28 rounded-xl object-cover" alt="">
                <img src="{{ $img['group'] }}" class="h-28 rounded-xl object-cover" alt="">
            </div>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-semibold text-forest">Jadwal Kegiatan Harian</h3>
            <ul class="space-y-3 text-sm">
                @forelse (($schedules ?? collect()) as $j)
                    <li class="flex gap-4 border-l-2 border-forest/20 pl-4">
                        <span class="w-14 font-semibold text-forest">{{ $j->time }}</span>
                        <span class="text-muted">{{ $j->activity }}</span>
                    </li>
                @empty
                    <li class="text-muted">Belum ada jadwal. Tambahkan lewat admin.</li>
                @endforelse
            </ul>
        </div>
        <aside class="mosque-watermark rounded-3xl bg-sand p-7">
            <p class="font-arabic text-right text-3xl text-forest">{{ $contents['pendidikan.aside_ar'] ?? 'الْعِلْمُ نُورٌ' }}</p>
            <p class="mt-4 font-serif text-2xl text-forest">{{ $contents['pendidikan.aside_title'] ?? 'Ilmu adalah cahaya' }}</p>
            <p class="mt-3 text-sm leading-relaxed text-muted">{{ $contents['pendidikan.aside_text'] ?? 'Cahaya itu merawat hati, menuntun langkah, dan membuat manfaat sampai kepada orang lain.' }}</p>
        </aside>
    </div>
</section>

@include('partials.cta-banner', [
    'heading' => $contents['pendidikan.cta_title'] ?? 'Bersama Kami, Wujudkan Masa Depan yang Lebih Baik.',
    'text' => $contents['pendidikan.cta_text'] ?? 'Konsultasikan jenjang dan program yang sesuai dengan putra-putri Anda.',
    'button' => $contents['pendidikan.cta_button'] ?? 'Daftar Sekarang',
])
@endsection
