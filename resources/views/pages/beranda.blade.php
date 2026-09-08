@extends('layouts.app', ['title' => 'Beranda'])

@section('content')
<section class="relative min-h-[620px] overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ $img['campus'] }}" alt="Kampus {{ config('ponpes.name') }}" class="h-full w-full object-cover">
        <div class="absolute inset-0 bg-forest-deeper/45"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-forest-deeper/70 via-forest/30 to-transparent"></div>
    </div>

    <div class="container-site relative grid min-h-[620px] items-center gap-10 py-20 lg:grid-cols-[1.15fr_.85fr]">
        <div class="max-w-2xl text-white">
            <p class="text-xs font-semibold tracking-[0.22em] text-white/80">{{ $contents['beranda.hero_eyebrow'] ?? 'PONDOK PESANTREN NURUL HUDA' }}</p>
            <h1 class="mt-4 font-serif text-4xl leading-[1.15] font-semibold md:text-5xl">
                {{ $contents['beranda.hero_title'] ?? 'Membangun Generasi Qur’ani, Berilmu dan Berakhlakul Karimah' }}
            </h1>
            <p class="mt-5 max-w-xl text-sm leading-relaxed text-white/85 md:text-base">
                {{ $contents['beranda.hero_text'] ?? 'Lingkungan pendidikan yang memadukan ilmu agama dan pengetahuan umum, menumbuhkan adab, serta menyiapkan santri bermanfaat bagi umat.' }}
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('profil') }}" class="btn-forest">Tentang Pondok <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                <a href="{{ route('pendaftaran') }}" class="btn-outline-white">Pendaftaran Santri Baru</a>
            </div>
            <div class="mt-10 flex gap-2">
                <span class="h-2 w-6 rounded-full bg-white"></span>
                <span class="h-2 w-2 rounded-full bg-white/40"></span>
                <span class="h-2 w-2 rounded-full bg-white/40"></span>
            </div>
        </div>

        <aside class="hidden justify-self-end lg:block">
            <div class="max-w-xs rounded-2xl bg-white p-6 shadow-xl">
                <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-full bg-sand text-forest">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M7 6h6v12H9V10H7V6zm10 0h-4v4h2v8h2V6z"/></svg>
                </div>
                <p class="text-sm leading-relaxed text-ink">“{{ $contents['beranda.hero_quote'] ?? 'Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia.' }}”</p>
                <p class="mt-3 text-xs font-semibold text-forest">{{ $contents['beranda.hero_quote_by'] ?? 'HR. Ahmad' }}</p>
            </div>
        </aside>
    </div>
</section>

<section class="relative z-10 -mt-16 pb-6">
    <div class="container-site">
        <div class="card-soft grid overflow-hidden md:grid-cols-[1fr_220px]">
            <div class="grid gap-6 px-6 py-7 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    [$profile->stat_years ?? '20+', 'Tahun Berdiri'],
                    [$profile->stat_students ?? '1.500+', 'Santri Aktif'],
                    [$profile->stat_teachers ?? '100+', 'Tenaga Pengajar'],
                    [$profile->stat_alumni ?? '10.000+', 'Alumni'],
                ] as $stat)
                    <div>
                        <div class="mb-2 inline-flex h-10 w-10 items-center justify-center rounded-full bg-sand text-forest">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path d="M4 20V8l8-4 8 4v12M8 20v-6h8v6"/></svg>
                        </div>
                        <p class="font-serif text-3xl font-semibold text-forest">{{ $stat[0] }}</p>
                        <p class="text-sm text-muted">{{ $stat[1] }}</p>
                    </div>
                @endforeach
            </div>
            <div class="bg-sand px-6 py-7">
                <p class="font-arabic text-right text-2xl leading-relaxed text-forest">{{ $contents['beranda.stats_arabic'] ?? 'اطلبوا العلم' }}</p>
                <p class="mt-3 text-sm leading-relaxed text-ink">“{{ $contents['beranda.stats_quote'] ?? 'Tuntutlah ilmu dari buaian hingga liang lahat.' }}”</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16">
    <div class="container-site">
        <div class="mb-8 flex items-end justify-between gap-4">
            <div>
                <p class="text-xs font-semibold tracking-[0.18em] text-forest">PROGRAM PENDIDIKAN</p>
                <h2 class="mt-2 font-serif text-3xl font-semibold">Pendidikan Menyeluruh untuk Masa Depan</h2>
            </div>
            <a href="{{ route('pendidikan') }}" class="hidden text-sm font-semibold text-forest md:inline-flex">Lihat Semua Program →</a>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @forelse (($programs ?? collect()) as $program)
                <article class="group relative overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5">
                    <div class="h-40 overflow-hidden">
                        <img src="{{ $program->imageUrl() }}" alt="{{ $program->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-5">
                        <div class="-mt-10 mb-3 inline-flex h-12 w-12 items-center justify-center rounded-full bg-forest text-white shadow-lg">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path d="M4 19V6l8-3 8 3v13M4 19l8 3 8-3M12 3v16"/></svg>
                        </div>
                        <h3 class="font-serif text-xl font-semibold text-forest">{{ $program->title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $program->description }}</p>
                        <a href="{{ route('pendidikan') }}" class="mt-4 inline-flex h-9 w-9 items-center justify-center rounded-full bg-mist text-forest">→</a>
                    </div>
                </article>
            @empty
                <p class="col-span-full text-sm text-muted">Belum ada program. Tambahkan lewat admin.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="bg-mist py-16">
    <div class="container-site grid items-center gap-8 lg:grid-cols-[.85fr_1.15fr_.9fr]">
        <img src="{{ $profile->pengasuhPhotoUrl() }}" alt="{{ $profile->pengasuh_name }}" class="h-[420px] w-full rounded-[2rem] object-cover">
        <div>
            <p class="text-xs font-semibold tracking-[0.18em] text-forest">SAMBUTAN PENGASUH</p>
            <h2 class="mt-2 font-serif text-3xl font-semibold">{{ $contents['beranda.sambutan_title'] ?? 'Merawat Tradisi, Menyongsong Masa Depan' }}</h2>
            <p class="mt-4 text-sm leading-relaxed text-muted">
                {{ $profile->pengasuh_bio ?: 'Pondok ini didirikan untuk merawat tradisi keilmuan pesantren sekaligus membuka ruang bagi santri tumbuh di zaman yang terus berubah.' }}
            </p>
            <a href="{{ route('profil') }}" class="btn-forest mt-6">Baca Selengkapnya →</a>
        </div>
        <aside class="rounded-3xl bg-forest p-7 text-white">
            <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path d="M4 19V6l8-3 8 3v13M4 19l8 3 8-3"/></svg>
            </div>
            <h3 class="font-serif text-2xl font-semibold">{{ $contents['beranda.feature_title'] ?? 'Lingkungan yang Mendidik dan Membentuk' }}</h3>
            <p class="mt-3 text-sm text-white/75">{{ $contents['beranda.feature_text'] ?? 'Pembinaan berlangsung di asrama, kelas, dan masjid — bukan hanya di ruang belajar.' }}</p>
            <div class="mt-6 grid grid-cols-2 gap-3 text-sm">
                @foreach (preg_split('/\r\n|\r|\n/', $profile->features ?: "Asrama Nyaman\nPembinaan 24 Jam\nLingkungan Islami\nFasilitas Lengkap") as $fitur)
                    @if (trim($fitur) !== '')
                        <div class="rounded-xl bg-white/10 px-3 py-3">{{ trim($fitur) }}</div>
                    @endif
                @endforeach
            </div>
        </aside>
    </div>
</section>

<section class="py-16">
    <div class="container-site grid gap-10 lg:grid-cols-2">
        <div>
            <div class="mb-5 flex items-end justify-between">
                <div>
                    <p class="text-xs font-semibold tracking-[0.18em] text-forest">KEHIDUPAN SANTRI</p>
                    <h2 class="mt-2 font-serif text-3xl font-semibold">Langkah Kecil, Cerita Besar</h2>
                </div>
                <a href="{{ route('galeri') }}" class="text-sm font-semibold text-forest">Lihat Galeri →</a>
            </div>
            <div class="grid grid-cols-3 gap-3">
                @php
                    $homeGallery = ($galleries ?? collect())->take(5);
                    $fallbackGallery = [$img['students'], $img['prayer'], $img['sport'], $img['courtyard'], $img['group']];
                @endphp
                @forelse ($homeGallery as $i => $g)
                    <img src="{{ $g->imageUrl() }}" class="{{ $i === 0 ? 'col-span-2 h-52' : 'h-36' }} {{ $i === 1 ? 'h-52' : '' }} rounded-2xl object-cover" alt="{{ $g->title }}">
                @empty
                    @foreach ($fallbackGallery as $i => $src)
                        <img src="{{ $src }}" class="{{ $i === 0 ? 'col-span-2 h-52' : ($i === 1 ? 'h-52' : 'h-36') }} rounded-2xl object-cover" alt="Galeri">
                    @endforeach
                @endforelse
            </div>
        </div>
        <div>
            <div class="mb-5 flex items-end justify-between">
                <div>
                    <p class="text-xs font-semibold tracking-[0.18em] text-forest">BERITA TERKINI</p>
                    <h2 class="mt-2 font-serif text-3xl font-semibold">Informasi & Kegiatan</h2>
                </div>
                <a href="{{ route('berita') }}" class="text-sm font-semibold text-forest">Lihat Semua →</a>
            </div>
            <div class="space-y-4">
                @forelse (($posts ?? collect()) as $news)
                    <a href="{{ route('berita.show', $news) }}" class="flex gap-4">
                        <img src="{{ $news->coverUrl() }}" alt="" class="h-24 w-32 shrink-0 rounded-xl object-cover">
                        <div>
                            <p class="text-xs text-muted">{{ optional($news->published_at)->format('d M Y') }}</p>
                            <h3 class="mt-1 font-semibold text-forest">{{ $news->title }}</h3>
                            <p class="mt-1 line-clamp-2 text-sm text-muted">{{ $news->excerpt }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-muted">Belum ada berita. Tambahkan lewat panel admin.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="relative overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ $img['walking'] }}" alt="" class="h-full w-full object-cover">
        <div class="absolute inset-0 bg-forest/85"></div>
    </div>
    <div class="container-site relative grid items-center gap-8 py-16 lg:grid-cols-2">
        <div class="text-white">
            <h2 class="font-serif text-3xl font-semibold md:text-4xl">{{ $contents['beranda.cta_title'] ?? 'Bergabunglah Bersama Kami' }}</h2>
            <p class="mt-3 max-w-lg text-sm text-white/80">{{ $contents['beranda.cta_text'] ?? 'Buka kesempatan bagi putra-putri untuk tumbuh dalam lingkungan yang merawat ilmu, adab, dan manfaat.' }}</p>
            <a href="{{ route('pendaftaran') }}" class="btn-gold mt-6">Daftar Sekarang →</a>
        </div>
        <div class="justify-self-end">
            <div class="max-w-sm rounded-2xl border border-white/30 p-6 text-white">
                <p class="text-sm leading-relaxed">“{{ $contents['beranda.cta_quote'] ?? 'Belajar adalah perjalanan panjang. Setiap langkah kecil hari ini adalah bekal untuk bermanfaat esok hari.' }}”</p>
            </div>
        </div>
    </div>
</section>
@endsection
