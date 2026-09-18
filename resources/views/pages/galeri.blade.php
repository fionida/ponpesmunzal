@extends('layouts.app', ['title' => 'Galeri'])

@section('content')
@include('partials.page-hero', [
    'image' => $img['students'],
    'crumb' => 'Galeri',
    'heading' => $contents['galeri.hero_title'] ?? 'Galeri Kegiatan',
    'text' => $contents['galeri.hero_text'] ?? 'Dokumentasi perjalanan, ibadah, belajar, dan kehidupan sehari-hari santri.',
    'quote' => $contents['galeri.quote'] ?? 'Setiap momen adalah bagian dari proses mendidik generasi.',
    'quoteBy' => $profile->pengasuh_name ?? 'KH. Ahmad Fauzi, Lc.',
])

<section class="relative z-10 -mt-8">
    <div class="container-site">
        <div class="card-soft flex gap-2 overflow-x-auto p-3">
            @foreach (['' => 'Semua','Kegiatan Harian' => 'Kegiatan Harian','Kegiatan Keagamaan' => 'Kegiatan Keagamaan','Kegiatan Akademik' => 'Kegiatan Akademik','Ekstrakurikuler' => 'Ekstrakurikuler','Sarana & Prasarana' => 'Sarana & Prasarana','Kunjungan Tamu' => 'Kunjungan Tamu','Prestasi' => 'Prestasi'] as $key => $label)
                <a href="{{ route('galeri', array_filter(['kategori' => $key ?: null])) }}" class="shrink-0 rounded-xl px-4 py-3 text-sm font-medium {{ request('kategori', '') === $key ? 'bg-forest text-white' : 'hover:bg-mist' }}">{{ $label }}</a>
            @endforeach
        </div>
    </div>

    <div class="container-site py-16">
        <div class="mb-6">
            <h2 class="font-serif text-3xl font-semibold">{{ $contents['galeri.foto_title'] ?? 'Galeri Foto' }}</h2>
            <p class="mt-1 text-sm text-muted">{{ $contents['galeri.foto_text'] ?? 'Kumpulan dokumentasi kegiatan pondok.' }}</p>
        </div>

        @php $featuredFotos = $fotos->take(4); $restFotos = $fotos->skip(4); @endphp

        <div class="mb-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($featuredFotos as $f)
                <article class="relative h-72 overflow-hidden rounded-2xl">
                    <img src="{{ $f->imageUrl() }}" alt="{{ $f->title }}" class="h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-deeper/80 via-transparent to-transparent"></div>
                    <div class="absolute right-0 bottom-0 left-0 p-4 text-white">
                        <h3 class="font-semibold">{{ $f->title }}</h3>
                        <p class="text-xs text-white/75">{{ optional($f->taken_at)->format('d M Y') }}</p>
                    </div>
                </article>
            @empty
                @foreach ([$img['quran'], $img['students'], $img['books'], $img['sport']] as $i => $src)
                    <article class="relative h-72 overflow-hidden rounded-2xl">
                        <img src="{{ $src }}" alt="Galeri" class="h-full w-full object-cover">
                    </article>
                @endforeach
            @endforelse
        </div>

        <div class="grid grid-cols-2 gap-3 md:grid-cols-4 lg:grid-cols-6">
            @forelse ($restFotos as $g)
                <img src="{{ $g->imageUrl() }}" alt="{{ $g->title }}" class="h-28 w-full rounded-xl object-cover">
            @empty
                @foreach ([$img['library'],$img['classroom'],$img['prayer'],$img['group'],$img['courtyard'],$img['mosque']] as $g)
                    <img src="{{ $g }}" alt="Galeri pondok" class="h-28 w-full rounded-xl object-cover">
                @endforeach
            @endforelse
            <div class="flex h-28 flex-col items-center justify-center rounded-xl bg-forest text-center text-white">
                <span class="text-sm font-semibold">Total Foto</span>
                <span class="text-xs text-white/70">{{ $fotos->count() }}+</span>
            </div>
        </div>
    </div>
</section>

<section class="bg-mist py-16">
    <div class="container-site">
        <div class="mb-8">
            <h2 class="font-serif text-3xl font-semibold">{{ $contents['galeri.video_title'] ?? 'Galeri Video' }}</h2>
            <p class="mt-1 text-sm text-muted">Profil, kegiatan, dan cuplikan kehidupan santri.</p>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($videos as $v)
                <article>
                    <a href="{{ $v->video_url ?: '#' }}" @if($v->video_url) target="_blank" @endif class="relative block overflow-hidden rounded-2xl">
                        <img src="{{ $v->imageUrl() }}" alt="{{ $v->title }}" class="h-44 w-full object-cover">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/25">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white text-forest">▶</span>
                        </div>
                        @if ($v->duration)
                            <span class="absolute right-3 bottom-3 rounded bg-black/70 px-2 py-0.5 text-[11px] text-white">{{ $v->duration }}</span>
                        @endif
                    </a>
                    <h3 class="mt-3 font-semibold text-forest">{{ $v->title }}</h3>
                    <p class="text-xs text-muted">{{ optional($v->taken_at)->format('d M Y') }}</p>
                </article>
            @empty
                <p class="text-sm text-muted">Belum ada video. Tambahkan lewat admin.</p>
            @endforelse
        </div>
    </div>
</section>

@include('partials.cta-banner', [
    'heading' => $contents['galeri.cta_title'] ?? 'Setiap Foto, Punya Cerita',
    'text' => $contents['galeri.cta_text'] ?? 'Kirim dokumentasi kegiatan yang pantas dibagikan kepada keluarga besar pondok.',
    'button' => $contents['galeri.cta_button'] ?? 'Kirim Dokumentasi',
    'href' => route('kontak'),
])
@endsection
