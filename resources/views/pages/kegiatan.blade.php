@extends('layouts.app', ['title' => 'Kegiatan'])

@section('content')
@include('partials.page-hero', [
    'image' => $img['classroom'],
    'crumb' => 'Kegiatan',
    'heading' => $contents['kegiatan.hero_title'] ?? 'Kegiatan Pesantren',
    'text' => $contents['kegiatan.hero_text'] ?? 'Rangkaian kegiatan yang menumbuhkan ilmu, adab, kepemimpinan, dan kepedulian sosial santri.',
    'quote' => $contents['kegiatan.quote'] ?? 'Kegiatan pondok bukan pengisi waktu, melainkan ruang membentuk karakter.',
    'quoteBy' => $contents['kegiatan.quote_by'] ?? ($profile->pengasuh_name ?? 'KH. Ahmad Fauzi, Lc.'),
])

<section class="relative z-10 -mt-8" x-data="{ filter: 'semua' }">
    <div class="container-site">
        <div class="card-soft flex gap-2 overflow-x-auto p-3">
            @foreach (['semua' => 'Semua Kegiatan','keagamaan' => 'Keagamaan','akademik' => 'Akademik','ekskul' => 'Ekstrakurikuler','sosial' => 'Sosial & Kemasyarakatan','pimpinan' => 'Kepemimpinan','olahraga' => 'Kesehatan & Olahraga'] as $key => $label)
                <button type="button" @click="filter = '{{ $key }}'" :class="filter === '{{ $key }}' ? 'bg-forest text-white' : 'text-ink hover:bg-mist'" class="shrink-0 rounded-xl px-4 py-3 text-sm font-medium">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="container-site py-16">
        <div class="mb-8 flex items-end justify-between">
            <div>
                <p class="text-xs font-semibold tracking-[0.18em] text-forest">KEGIATAN TERBARU</p>
                <h2 class="mt-2 font-serif text-3xl font-semibold">Informasi Kegiatan Pesantren</h2>
            </div>
            <a href="{{ route('berita') }}" class="text-sm font-semibold text-forest">Lihat Semua Kegiatan →</a>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-5">
            @forelse (($posts ?? collect()) as $k)
                <article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5">
                    <div class="relative">
                        <img src="{{ $k->coverUrl() }}" alt="{{ $k->title }}" class="h-36 w-full object-cover">
                        <span class="absolute top-3 left-3 rounded-full bg-forest px-2.5 py-1 text-[11px] font-semibold text-white">{{ $k->category }}</span>
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-muted">{{ optional($k->published_at)->translatedFormat('d F Y') }}</p>
                        <h3 class="mt-1 font-semibold text-forest">{{ $k->title }}</h3>
                        <p class="mt-2 line-clamp-3 text-sm text-muted">{{ $k->excerpt }}</p>
                        <a href="{{ route('berita.show', $k) }}" class="mt-3 inline-flex text-sm font-semibold text-forest">Baca Selengkapnya →</a>
                    </div>
                </article>
            @empty
                <p class="text-sm text-muted">Belum ada kegiatan. Tambahkan lewat admin berita.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="bg-forest py-16 text-white">
    <div class="container-site grid items-center gap-10 lg:grid-cols-2">
        <div>
            <p class="text-xs font-semibold tracking-[0.18em] text-gold">KEGIATAN UNGGULAN</p>
            <h2 class="mt-3 font-serif text-3xl font-semibold">{{ $contents['kegiatan.unggulan_title'] ?? 'Rutinan Ngaji Kitab Kuning' }}</h2>
            <p class="mt-4 max-w-lg text-sm text-white/80">{{ $contents['kegiatan.unggulan_text'] ?? 'Kajian bandongan dan sorogan yang merawat sanad keilmuan, membentuk adab kepada guru, dan menajamkan pemahaman fikih, akhlak, serta tafsir.' }}</p>
            <a href="{{ route('pendidikan') }}" class="btn-gold mt-6">Lihat Detail Kegiatan</a>
        </div>
        <div>
            <h3 class="mb-4 text-sm font-semibold tracking-wide text-gold">MANFAAT KEGIATAN</h3>
            <ul class="space-y-3 text-sm">
                @foreach (preg_split('/\r\n|\r|\n/', $contents['kegiatan.manfaat'] ?? "Memperdalam ilmu agama\nMelatih adab kepada guru\nMenjaga kesinambungan tradisi\nMembuka ruang diskusi ilmiah\nMembentuk karakter istiqamah") as $m)
                    @if (trim($m) !== '')
                        <li class="flex items-center gap-3 rounded-xl bg-white/10 px-4 py-3">{{ trim($m) }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</section>

<section class="py-16">
    <div class="container-site">
        <div class="mb-8 flex items-end justify-between">
            <div>
                <p class="text-xs font-semibold tracking-[0.18em] text-forest">DOKUMENTASI</p>
                <h2 class="mt-2 font-serif text-3xl font-semibold">Galeri Kegiatan</h2>
            </div>
            <a href="{{ route('galeri') }}" class="text-sm font-semibold text-forest">Lihat Semua Galeri →</a>
        </div>
        <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-6">
            @forelse (($galleries ?? collect()) as $g)
                <img src="{{ $g->imageUrl() }}" alt="{{ $g->title }}" class="h-40 w-full rounded-2xl object-cover">
            @empty
                @foreach ([$img['students'],$img['prayer'],$img['sport'],$img['group'],$img['quran'],$img['courtyard']] as $g)
                    <img src="{{ $g }}" alt="Dokumentasi kegiatan" class="h-40 w-full rounded-2xl object-cover">
                @endforeach
            @endforelse
        </div>
    </div>
</section>

@include('partials.cta-banner', [
    'heading' => 'Mari Dukung Kegiatan Pesantren',
    'text' => 'Dukungan Anda membantu kegiatan belajar, ibadah, dan pengabdian santri tetap berjalan.',
    'button' => 'Hubungi Kami',
    'href' => route('kontak'),
])
@endsection
