@extends('layouts.admin', ['title' => 'Dashboard', 'heading' => 'Dashboard', 'subtitle' => 'Ringkasan aktivitas dan konten pondok'])

@section('content')
{{-- Metro tiles --}}
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <a href="{{ route('admin.berita.index') }}" class="metro-tile" style="background: linear-gradient(135deg, #1b84ff 0%, #056ee9 100%);">
        <div class="relative z-10 flex items-start justify-between">
            <div>
                <p class="text-sm text-white/80">Total Berita</p>
                <p class="mt-2 text-3xl font-bold">{{ $postsCount }}</p>
            </div>
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white/15">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M4 5h12a2 2 0 012 2v12H6a2 2 0 01-2-2V5z"/><path d="M8 10h8M8 14h5"/></svg>
            </span>
        </div>
        <p class="relative z-10 text-xs text-white/75">{{ $publishedCount }} sudah terbit</p>
    </a>

    <a href="{{ route('admin.galeri.index') }}" class="metro-tile" style="background: linear-gradient(135deg, #17c653 0%, #0ea743 100%);">
        <div class="relative z-10 flex items-start justify-between">
            <div>
                <p class="text-sm text-white/80">Galeri</p>
                <p class="mt-2 text-3xl font-bold">{{ $galleriesCount }}</p>
            </div>
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white/15">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 16l5-4 4 3 3-2 6 4"/></svg>
            </span>
        </div>
        <p class="relative z-10 text-xs text-white/75">Foto & video dokumentasi</p>
    </a>

    <a href="{{ route('admin.pendaftaran.index') }}" class="metro-tile" style="background: linear-gradient(135deg, #f6c000 0%, #d9a800 100%);">
        <div class="relative z-10 flex items-start justify-between">
            <div>
                <p class="text-sm text-white/90">Pendaftar Baru</p>
                <p class="mt-2 text-3xl font-bold text-[#1e1e2d]">{{ $registrationsNew }}</p>
            </div>
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-black/10 text-[#1e1e2d]">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M9 12h6M9 16h6M7 4h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/></svg>
            </span>
        </div>
        <p class="relative z-10 text-xs text-[#1e1e2d]/80">Perlu ditindaklanjuti</p>
    </a>

    <a href="{{ route('admin.pesan.index') }}" class="metro-tile" style="background: linear-gradient(135deg, #05443b 0%, #03352e 100%);">
        <div class="relative z-10 flex items-start justify-between">
            <div>
                <p class="text-sm text-white/80">Pesan Baru</p>
                <p class="mt-2 text-3xl font-bold">{{ $messagesUnread }}</p>
            </div>
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white/15">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M4 6h16v12H4z"/><path d="M4 7l8 6 8-6"/></svg>
            </span>
        </div>
        <p class="relative z-10 text-xs text-white/75">Dari formulir kontak</p>
    </a>
</div>

{{-- Quick actions --}}
<div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
    @foreach ([
        ['Tulis Berita', route('admin.berita.create'), '#1b84ff'],
        ['Tambah Galeri', route('admin.galeri.create'), '#17c653'],
        ['Edit Profil', route('admin.profil.edit'), '#05443b'],
        ['Cek Pendaftaran', route('admin.pendaftaran.index'), '#f6c000'],
    ] as [$label, $href, $color])
        <a href="{{ $href }}" class="metro-card flex items-center gap-3 px-4 py-3.5 transition hover:shadow-md">
            <span class="h-2.5 w-2.5 rounded-full" style="background: {{ $color }}"></span>
            <span class="text-sm font-semibold">{{ $label }}</span>
            <span class="ml-auto text-[#78829d]">→</span>
        </a>
    @endforeach
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-2">
    <section class="metro-card overflow-hidden">
        <div class="flex items-center justify-between border-b border-[#eff2f5] px-5 py-4">
            <div>
                <h2 class="font-semibold">Berita terbaru</h2>
                <p class="text-xs text-[#78829d]">Artikel yang baru ditambahkan</p>
            </div>
            <a href="{{ route('admin.berita.create') }}" class="text-sm font-semibold text-[#1b84ff]">+ Tulis</a>
        </div>
        <div class="divide-y divide-[#eff2f5]">
            @forelse ($latestPosts as $post)
                <a href="{{ route('admin.berita.edit', $post) }}" class="flex items-center gap-3 px-5 py-3.5 hover:bg-[#f9f9f9]">
                    <img src="{{ $post->coverUrl() }}" alt="" class="h-11 w-14 rounded-lg object-cover">
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium">{{ $post->title }}</p>
                        <p class="text-xs text-[#78829d]">{{ $post->category }} · {{ optional($post->published_at ?? $post->created_at)->format('d M Y') }}</p>
                    </div>
                    <span class="metro-badge {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $post->status }}</span>
                </a>
            @empty
                <p class="px-5 py-8 text-sm text-[#78829d]">Belum ada berita. Mulai tulis yang pertama.</p>
            @endforelse
        </div>
    </section>

    <section class="metro-card overflow-hidden">
        <div class="flex items-center justify-between border-b border-[#eff2f5] px-5 py-4">
            <div>
                <h2 class="font-semibold">Pendaftaran terbaru</h2>
                <p class="text-xs text-[#78829d]">Calon santri dari formulir publik</p>
            </div>
            <a href="{{ route('admin.pendaftaran.index') }}" class="text-sm font-semibold text-[#1b84ff]">Lihat semua</a>
        </div>
        <div class="divide-y divide-[#eff2f5]">
            @forelse ($latestRegistrations as $reg)
                <a href="{{ route('admin.pendaftaran.show', $reg) }}" class="flex items-center justify-between gap-3 px-5 py-3.5 hover:bg-[#f9f9f9]">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium">{{ $reg->nama }}</p>
                        <p class="text-xs text-[#78829d]">{{ $reg->program }} · {{ $reg->whatsapp }}</p>
                    </div>
                    <span class="metro-badge bg-[#fff8dd] text-[#c59a00]">{{ $reg->status }}</span>
                </a>
            @empty
                <p class="px-5 py-8 text-sm text-[#78829d]">Belum ada pendaftar.</p>
            @endforelse
        </div>
        @if ($messagesUnread > 0)
            <div class="border-t border-[#eff2f5] bg-[#f1faff] px-5 py-3 text-sm text-[#1b84ff]">
                Ada <strong>{{ $messagesUnread }}</strong> pesan kontak belum dibaca.
                <a href="{{ route('admin.pesan.index') }}" class="font-semibold underline">Buka inbox</a>
            </div>
        @endif
    </section>
</div>
@endsection
