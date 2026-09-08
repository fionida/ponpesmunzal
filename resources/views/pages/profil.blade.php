@extends('layouts.app', ['title' => 'Profil'])

@section('content')
@include('partials.page-hero', [
    'image' => $img['campus'],
    'crumb' => 'Profil',
    'heading' => $contents['profil.hero_title'] ?? 'Profil Pondok Pesantren Nurul Huda',
    'text' => $contents['profil.hero_text'] ?? 'Mengenal sejarah, visi, pengasuh, dan arah pendidikan yang merawat tradisi sekaligus menyongsong masa depan.',
])

<section class="py-16" id="sekilas">
    <div class="container-site grid gap-10 lg:grid-cols-[240px_1fr]">
        <aside class="h-fit rounded-2xl bg-mist p-4">
            <nav class="space-y-1 text-sm">
                @foreach ([
                    ['#sekilas', 'Sekilas Profil', true],
                    ['#sejarah', 'Sejarah', false],
                    ['#visi', 'Visi, Misi & Tujuan', false],
                    ['#pengasuh', 'Pengasuh', false],
                    ['#fasilitas', 'Sarana & Prasarana', false],
                    ['#prestasi', 'Prestasi', false],
                ] as $item)
                    <a href="{{ $item[0] }}" class="block rounded-xl px-3 py-2.5 {{ $item[2] ? 'bg-forest text-white' : 'text-ink hover:bg-white' }}">{{ $item[1] }}</a>
                @endforeach
            </nav>
        </aside>

        <div>
            <p class="text-xs font-semibold tracking-[0.18em] text-forest">SEKILAS PROFIL</p>
            <h2 class="mt-2 font-serif text-3xl font-semibold">Rumah ilmu yang merawat adab</h2>
            <p class="mt-4 max-w-3xl text-sm leading-relaxed text-muted">
                {{ $profile->about ?: 'Pondok Pesantren Nurul Huda berdiri sebagai lembaga pendidikan Islam yang memadukan pengajian kitab, tahfidz, dan pendidikan formal.' }}
            </p>
            <blockquote class="my-6 border-l-4 border-gold pl-5 font-serif text-xl text-forest">
                “{{ $contents['profil.blockquote'] ?? 'Ilmu yang bermanfaat adalah ilmu yang menuntun adab, dan adab yang baik menuntun manfaat bagi sesama.' }}”
            </blockquote>
            <img src="{{ $img['library'] }}" alt="Santri di perpustakaan" class="mb-8 h-72 w-full rounded-3xl object-cover">

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    [$profile->stat_years ?? '20+', 'Tahun Berdiri'],
                    [$profile->stat_students ?? '1.500+', 'Santri Aktif'],
                    [$profile->stat_teachers ?? '100+', 'Tenaga Pengajar'],
                    [$profile->stat_alumni ?? '10.000+', 'Alumni'],
                ] as $stat)
                    <div class="rounded-2xl bg-mist p-5">
                        <p class="font-serif text-3xl font-semibold text-forest">{{ $stat[0] }}</p>
                        <p class="text-sm text-muted">{{ $stat[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section id="visi" class="bg-mist mosque-watermark py-16">
    <div class="container-site">
        <p class="text-xs font-semibold tracking-[0.18em] text-forest">ARAH PENDIDIKAN</p>
        <h2 class="mt-2 mb-8 font-serif text-3xl font-semibold">Visi, Misi & Tujuan</h2>
        <div class="grid gap-5 lg:grid-cols-3">
            <article class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="mb-4 inline-flex h-11 w-11 items-center justify-center rounded-full bg-sand text-forest">◉</div>
                <h3 class="font-serif text-2xl font-semibold text-forest">Visi</h3>
                <p class="mt-3 text-sm leading-relaxed text-muted">{{ $profile->vision ?: 'Menjadi pesantren unggul yang mencetak generasi Qur’ani, berilmu, beradab, dan bermanfaat bagi umat serta bangsa.' }}</p>
            </article>
            <article class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="mb-4 inline-flex h-11 w-11 items-center justify-center rounded-full bg-gold/20 text-gold-dark">◎</div>
                <h3 class="font-serif text-2xl font-semibold text-forest">Misi</h3>
                <ol class="mt-3 list-decimal space-y-2 pl-5 text-sm text-muted">
                    @foreach (preg_split('/\r\n|\r|\n/', $profile->mission ?: "Menyelenggarakan pendidikan tahfidz dan diniyah yang mutqin.\nMengintegrasikan kurikulum formal dengan nilai pesantren.\nMembina akhlak melalui keteladanan dan pembiasaan.\nMenumbuhkan jiwa pengabdian dan kemandirian santri.") as $misi)
                        @if (trim($misi) !== '')
                            <li>{{ trim($misi) }}</li>
                        @endif
                    @endforeach
                </ol>
            </article>
            <article class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="mb-4 inline-flex h-11 w-11 items-center justify-center rounded-full bg-sky-50 text-sky-700">★</div>
                <h3 class="font-serif text-2xl font-semibold text-forest">Tujuan</h3>
                <ol class="mt-3 list-decimal space-y-2 pl-5 text-sm text-muted">
                    @foreach (preg_split('/\r\n|\r|\n/', $profile->goals ?: "Santri hafal dan memahami Al-Qur’an sesuai jenjang.\nSantri mampu membaca kitab dan berpikir jernih.\nSantri memiliki adab kepada guru, teman, dan masyarakat.\nAlumni siap berkhidmat di berbagai bidang.") as $tujuan)
                        @if (trim($tujuan) !== '')
                            <li>{{ trim($tujuan) }}</li>
                        @endif
                    @endforeach
                </ol>
            </article>
        </div>
    </div>
</section>

<section id="sejarah" class="py-16">
    <div class="container-site grid items-start gap-10 lg:grid-cols-2">
        <div>
            <p class="text-xs font-semibold tracking-[0.18em] text-forest">SEJARAH SINGKAT</p>
            <h2 class="mt-2 font-serif text-3xl font-semibold">Tumbuh dari niat, merawat amanah</h2>
            <p class="mt-4 text-sm leading-relaxed text-muted">
                {{ $profile->history ?: 'Didirikan pada 2004 oleh KH. Ahmad Fauzi, Lc., pondok ini berawal dari pengajian kecil yang kemudian tumbuh menjadi lembaga pendidikan dengan asrama, madrasah, dan jenjang formal.' }}
            </p>
            <a href="#pengasuh" class="btn-forest mt-6">Selengkapnya tentang Sejarah</a>
        </div>
        <div class="relative space-y-6 border-l-2 border-forest/15 pl-8">
            @forelse (($timelines ?? collect()) as $item)
                <div class="relative">
                    <span class="absolute top-1 -left-[39px] h-4 w-4 rounded-full border-4 border-white bg-forest"></span>
                    <p class="font-serif text-xl font-semibold text-forest">{{ $item->year }}</p>
                    <p class="text-sm text-muted">{{ $item->title }}</p>
                </div>
            @empty
                <p class="text-sm text-muted">Belum ada timeline. Tambahkan lewat admin.</p>
            @endforelse
        </div>
    </div>
</section>

<section id="pengasuh" class="bg-mist py-16">
    <div class="container-site grid items-center gap-8 lg:grid-cols-[.8fr_1fr_.9fr]">
        <img src="{{ $profile->pengasuhPhotoUrl() }}" alt="{{ $profile->pengasuh_name }}" class="h-[380px] w-full rounded-[2rem] object-cover">
        <div>
            <p class="text-xs font-semibold tracking-[0.18em] text-forest">PENGASUH</p>
            <h2 class="mt-2 font-serif text-3xl font-semibold">{{ $profile->pengasuh_name ?: 'KH. Ahmad Fauzi, Lc.' }}</h2>
            <p class="mt-1 text-sm text-muted">{{ $profile->pengasuh_title ?: 'Pengasuh Pondok Pesantren Nurul Huda' }}</p>
            <p class="mt-4 text-sm leading-relaxed text-muted">{{ $profile->pengasuh_bio ?: 'Beliau menempuh pendidikan di pesantren dan perguruan tinggi di Timur Tengah, lalu pulang mengabdikan ilmu untuk membangun generasi yang kokoh dalam iman dan luas dalam wawasan.' }}</p>
            <a href="{{ route('kontak') }}" class="mt-4 inline-flex text-sm font-semibold text-forest">Profil Lengkap →</a>
        </div>
        <aside class="rounded-3xl bg-forest p-7 text-white">
            <p class="font-arabic text-right text-2xl leading-relaxed">{{ $contents['profil.pengasuh_quote_ar'] ?? 'وَقُل رَّبِّ زِدْنِي عِلْمًا' }}</p>
            <p class="mt-4 text-sm text-white/80">“{{ $contents['profil.pengasuh_quote'] ?? 'Ya Tuhanku, tambahkanlah ilmu kepadaku.' }}”</p>
            <p class="mt-3 text-xs font-semibold tracking-wide text-gold">{{ $contents['profil.pengasuh_quote_by'] ?? 'QS. Thaha: 114' }}</p>
        </aside>
    </div>
</section>

<section id="fasilitas" class="relative overflow-hidden py-16">
    <div class="absolute inset-0">
        <img src="{{ $img['courtyard'] }}" alt="" class="h-full w-full object-cover">
        <div class="absolute inset-0 bg-white/88"></div>
    </div>
    <div class="container-site relative">
        <div class="mb-8 flex items-end justify-between">
            <div>
                <p class="text-xs font-semibold tracking-[0.18em] text-forest">SARANA & PRASARANA</p>
                <h2 class="mt-2 font-serif text-3xl font-semibold">Fasilitas yang menunjang ibadah dan belajar</h2>
            </div>
            <a href="{{ route('pendidikan') }}" class="text-sm font-semibold text-forest">Lihat Detail Fasilitas →</a>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse (($facilities ?? collect()) as $f)
                <div class="rounded-2xl bg-white/90 p-5 shadow-sm backdrop-blur">
                    <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-full bg-sand text-forest">▣</div>
                    <h3 class="font-semibold text-forest">{{ $f->title }}</h3>
                </div>
            @empty
                <p class="text-sm text-muted">Belum ada fasilitas. Tambahkan lewat admin.</p>
            @endforelse
        </div>
    </div>
</section>

@include('partials.cta-banner', [
    'heading' => $contents['profil.cta_title'] ?? 'Mari menjadi bagian dari keluarga besar Nurul Huda',
    'text' => 'Pendaftaran santri baru dibuka. Konsultasikan program yang sesuai bersama panitia.',
])
@endsection
