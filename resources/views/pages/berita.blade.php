@extends('layouts.app', ['title' => 'Berita'])

@section('content')
@include('partials.page-hero', [
    'image' => $img['classroom'],
    'crumb' => 'Berita',
    'heading' => $contents['berita.hero_title'] ?? 'Berita & Informasi',
    'text' => $contents['berita.hero_text'] ?? 'Kabar kegiatan, prestasi, pengumuman, dan liputan kehidupan pondok.',
    'quote' => $contents['berita.quote'] ?? 'Sampaikanlah dariku walau hanya satu ayat.',
    'quoteBy' => $contents['berita.quote_by'] ?? 'HR. Bukhari',
])

<section class="relative z-10 -mt-8">
    <div class="container-site">
        <div class="card-soft flex flex-wrap items-center justify-between gap-3 p-3">
            <div class="flex flex-wrap gap-2">
                @foreach (['' => 'Semua Berita','Kegiatan' => 'Kegiatan','Prestasi' => 'Prestasi','Pengumuman' => 'Pengumuman','Artikel' => 'Artikel','Liputan Khusus' => 'Liputan Khusus'] as $key => $label)
                    <a href="{{ route('berita', array_filter(['kategori' => $key ?: null, 'q' => request('q')])) }}" class="rounded-xl px-4 py-2.5 text-sm font-medium {{ request('kategori', '') === $key ? 'bg-forest text-white' : 'hover:bg-mist' }}">{{ $label }}</a>
                @endforeach
            </div>
            <form action="{{ route('berita') }}" class="flex min-w-[220px] flex-1 md:max-w-xs">
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari berita..." class="input-field !rounded-r-none">
                <button class="rounded-r-xl bg-forest px-4 text-white">Cari</button>
            </form>
        </div>
    </div>

    <div class="container-site grid gap-8 py-16 lg:grid-cols-[1fr_300px]">
        <div>
            <p class="text-xs font-semibold tracking-[0.18em] text-forest">BERITA TERBARU</p>
            <h2 class="mt-2 font-serif text-3xl font-semibold">Berita Terkini</h2>
            <p class="mt-2 mb-6 text-sm text-muted">Informasi terbaru dari kehidupan dan kegiatan pondok.</p>

            @if ($featured)
                <article class="mb-8 overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-black/5">
                    <img src="{{ $featured->coverUrl() }}" alt="{{ $featured->title }}" class="h-72 w-full object-cover">
                    <div class="p-6">
                        <div class="flex items-center gap-3 text-xs">
                            <span class="rounded-full bg-forest px-2.5 py-1 font-semibold text-white">{{ $featured->category }}</span>
                            <span class="text-muted">{{ optional($featured->published_at)->format('d M Y') }}</span>
                        </div>
                        <h3 class="mt-3 font-serif text-2xl font-semibold text-forest">{{ $featured->title }}</h3>
                        <p class="mt-2 text-sm text-muted">{{ $featured->excerpt }}</p>
                        <a href="{{ route('berita.show', $featured) }}" class="mt-4 inline-flex text-sm font-semibold text-forest">Baca Selengkapnya →</a>
                    </div>
                </article>
            @endif

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($posts->skip($featured ? 1 : 0) as $n)
                    <article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5">
                        <div class="relative">
                            <img src="{{ $n->coverUrl() }}" alt="{{ $n->title }}" class="h-36 w-full object-cover">
                            <span class="absolute top-3 left-3 rounded-full bg-forest px-2.5 py-1 text-[11px] font-semibold text-white">{{ $n->category }}</span>
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-muted">{{ optional($n->published_at)->format('d M Y') }}</p>
                            <h3 class="mt-1 font-semibold text-forest">{{ $n->title }}</h3>
                            <p class="mt-2 line-clamp-2 text-sm text-muted">{{ $n->excerpt }}</p>
                            <a href="{{ route('berita.show', $n) }}" class="mt-3 inline-flex text-sm font-semibold text-forest">Baca Selengkapnya →</a>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full text-sm text-muted">Belum ada berita published. Tambahkan lewat admin.</p>
                @endforelse
            </div>

            <div class="mt-10">{{ $posts->links() }}</div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5">
                <h3 class="mb-4 font-semibold text-forest">Berita Populer</h3>
                <ol class="space-y-4">
                    @forelse ($popular as $i => $t)
                        <li class="flex gap-3 text-sm">
                            <span class="font-serif text-lg font-semibold text-gold">{{ $i+1 }}</span>
                            <a href="{{ route('berita.show', $t) }}">
                                <span class="font-medium text-ink">{{ $t->title }}</span>
                                <span class="block text-xs text-muted">{{ optional($t->published_at)->format('Y') }}</span>
                            </a>
                        </li>
                    @empty
                        <li class="text-muted">Belum ada data.</li>
                    @endforelse
                </ol>
            </div>
            <div class="mosque-watermark rounded-2xl bg-sand p-5">
                <h3 class="font-semibold text-forest">Berlangganan Berita</h3>
                <p class="mt-2 mb-3 text-sm text-muted">Dapatkan kabar pondok langsung di email Anda.</p>
                <form action="{{ route('newsletter.submit') }}" method="POST" class="space-y-2">
                    @csrf
                    <input type="email" name="email" required class="input-field" placeholder="Email">
                    <button class="btn-forest w-full">Kirim</button>
                </form>
            </div>
        </aside>
    </div>
</section>

@include('partials.cta-banner', [
    'heading' => 'Dukung pendidikan santri',
    'text' => 'Kontribusi Anda membantu kegiatan belajar dan pembinaan tetap berjalan.',
    'button' => 'Dukung Kami',
    'href' => route('kontak'),
])
@endsection
