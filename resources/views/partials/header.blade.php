@php
    $nav = [
        ['route' => 'beranda', 'label' => 'Beranda'],
        ['route' => 'profil', 'label' => 'Profil'],
        ['route' => 'pendidikan', 'label' => 'Pendidikan'],
        ['route' => 'kegiatan', 'label' => 'Kegiatan'],
        ['route' => 'berita', 'label' => 'Berita'],
        ['route' => 'galeri', 'label' => 'Galeri'],
        ['route' => 'kontak', 'label' => 'Kontak'],
    ];
@endphp

<header class="sticky top-0 z-50 border-b border-black/5 bg-white/95 backdrop-blur">
    <div class="container-site flex h-[78px] items-center justify-between gap-4">
        <a href="{{ route('beranda') }}" class="flex min-w-0 items-center gap-3">
            @include('partials.logo', ['size' => 42])
            <span class="min-w-0">
                <span class="block truncate text-[15px] font-semibold leading-tight text-forest">{{ config('ponpes.name') }}</span>
                <span class="block text-[11px] tracking-wide text-muted">{{ config('ponpes.tagline') }}</span>
            </span>
        </a>

        <nav class="hidden items-center gap-6 xl:flex">
            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}" class="nav-link {{ request()->routeIs($item['route']) ? 'is-active' : '' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <button type="button" @click="searchOpen = true" class="hidden h-10 w-10 items-center justify-center rounded-full text-forest hover:bg-mist md:inline-flex" aria-label="Cari">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
            </button>
            <span class="hidden h-6 w-px bg-black/10 md:block"></span>
            <a href="{{ route('pendaftaran') }}" class="btn-forest !px-4 !py-2.5 text-sm">
                Pendaftaran
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
            <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-forest xl:hidden" @click="menuOpen = !menuOpen" aria-label="Menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </div>

    <div x-show="menuOpen" x-transition class="border-t border-black/5 bg-white xl:hidden" x-cloak>
        <nav class="container-site flex flex-col py-3">
            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}" class="py-2.5 text-sm font-medium {{ request()->routeIs($item['route']) ? 'text-forest' : 'text-ink' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</header>
