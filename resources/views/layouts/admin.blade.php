<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} | CMS Admin</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</head>
@php
    $menus = [
        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'match' => 'admin.dashboard', 'group' => 'Utama', 'icon' => 'home'],
        ['route' => 'admin.berita.index', 'label' => 'Berita', 'match' => 'admin.berita.*', 'group' => 'Konten', 'icon' => 'news'],
        ['route' => 'admin.galeri.index', 'label' => 'Galeri', 'match' => 'admin.galeri.*', 'group' => 'Konten', 'icon' => 'gallery'],
        ['route' => 'admin.profil.edit', 'label' => 'Profil Pondok', 'match' => 'admin.profil.*', 'group' => 'Konten', 'icon' => 'profile'],
        ['route' => 'admin.konten.edit', 'label' => 'Teks Halaman', 'match' => 'admin.konten.*', 'group' => 'Konten', 'icon' => 'mail'],
        ['route' => 'admin.program.index', 'label' => 'Program', 'match' => 'admin.program.*', 'group' => 'Master', 'icon' => 'news'],
        ['route' => 'admin.fasilitas.index', 'label' => 'Fasilitas', 'match' => 'admin.fasilitas.*', 'group' => 'Master', 'icon' => 'gallery'],
        ['route' => 'admin.faq.index', 'label' => 'FAQ', 'match' => 'admin.faq.*', 'group' => 'Master', 'icon' => 'mail'],
        ['route' => 'admin.timeline.index', 'label' => 'Timeline Sejarah', 'match' => 'admin.timeline.*', 'group' => 'Master', 'icon' => 'reg'],
        ['route' => 'admin.jadwal.index', 'label' => 'Jadwal Harian', 'match' => 'admin.jadwal.*', 'group' => 'Master', 'icon' => 'reg'],
        ['route' => 'admin.pendaftaran.index', 'label' => 'Pendaftaran', 'match' => 'admin.pendaftaran.*', 'group' => 'Layanan', 'icon' => 'reg'],
        ['route' => 'admin.pesan.index', 'label' => 'Pesan Kontak', 'match' => 'admin.pesan.*', 'group' => 'Layanan', 'icon' => 'mail'],
    ];
    $grouped = collect($menus)->groupBy('group');
@endphp
<body class="admin-shell min-h-screen bg-[#f5f8fa] text-[#252f4a] antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        {{-- Overlay mobile --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/40 lg:hidden"></div>

        {{-- Sidebar --}}
        <aside
            class="metro-sidebar fixed inset-y-0 left-0 z-50 flex w-[265px] -translate-x-full flex-col transition-transform duration-200 lg:static lg:translate-x-0"
            :class="sidebarOpen && '!translate-x-0'"
        >
            <div class="flex h-[70px] items-center gap-3 border-b border-white/5 px-5">
                @include('partials.logo', ['size' => 36])
                <div class="min-w-0">
                    <p class="truncate text-[15px] font-semibold text-white">Nurul Munzal</p>
                    <p class="text-[11px] text-[#9899ac]">CMS Admin Panel</p>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-5">
                @foreach ($grouped as $group => $items)
                    <p class="mb-2 px-3 text-[11px] font-semibold tracking-[0.12em] text-[#565674] uppercase">{{ $group }}</p>
                    <div class="mb-5 space-y-1">
                        @foreach ($items as $item)
                            @php $active = request()->routeIs($item['match']); @endphp
                            <a href="{{ route($item['route']) }}" class="metro-nav-link {{ $active ? 'is-active' : '' }}">
                                <span class="metro-nav-icon">
                                    @if ($item['icon'] === 'home')
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1v-9.5z"/></svg>
                                    @elseif ($item['icon'] === 'news')
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M4 5h12a2 2 0 012 2v12H6a2 2 0 01-2-2V5z"/><path d="M18 7h2a2 2 0 012 2v8a3 3 0 01-3 3H8"/><path d="M8 10h8M8 14h5"/></svg>
                                    @elseif ($item['icon'] === 'gallery')
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="1.5"/><path d="M3 16l5-4 4 3 3-2 6 4"/></svg>
                                    @elseif ($item['icon'] === 'profile')
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.5"/><path d="M5 19a7 7 0 0114 0"/></svg>
                                    @elseif ($item['icon'] === 'reg')
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M9 12h6M9 16h6M7 4h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/></svg>
                                    @else
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M4 6h16M4 12h10M4 18h14"/><circle cx="18" cy="12" r="2"/></svg>
                                    @endif
                                </span>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </nav>

            <div class="border-t border-white/5 p-3">
                <a href="{{ route('beranda') }}" target="_blank" class="metro-nav-link mb-1">
                    <span class="metro-nav-icon">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M14 5h5v5M10 14L19 5M19 13v5a1 1 0 01-1 1H6a1 1 0 01-1-1V6a1 1 0 011-1h5"/></svg>
                    </span>
                    Lihat Situs
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="metro-nav-link w-full text-left">
                        <span class="metro-nav-icon">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M15 12H4M10 8l-4 4 4 4M15 4h3a2 2 0 012 2v12a2 2 0 01-2 2h-3"/></svg>
                        </span>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-30 flex h-[70px] items-center justify-between gap-4 border-b border-[#eff2f5] bg-white px-4 lg:px-8">
                <div class="flex min-w-0 items-center gap-3">
                    <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-[#eff2f5] text-[#78829d] hover:bg-[#f5f8fa] lg:hidden" @click="sidebarOpen = !sidebarOpen" aria-label="Menu">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                    </button>
                    <div class="min-w-0">
                        <div class="mb-0.5 hidden text-xs text-[#78829d] sm:flex sm:items-center sm:gap-1.5">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#1b84ff]">CMS</a>
                            <span>/</span>
                            <span class="text-[#252f4a]">{{ $heading ?? $title ?? 'Dashboard' }}</span>
                        </div>
                        <h1 class="truncate text-lg font-semibold text-[#252f4a]">{{ $heading ?? $title ?? 'Dashboard' }}</h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('beranda') }}" target="_blank" class="hidden items-center gap-2 rounded-lg border border-[#eff2f5] px-3 py-2 text-sm font-medium text-[#78829d] hover:bg-[#f5f8fa] sm:inline-flex" title="Lihat situs">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M14 5h5v5M10 14L19 5M19 13v5a1 1 0 01-1 1H6a1 1 0 01-1-1V6a1 1 0 011-1h5"/></svg>
                        Situs
                    </a>
                    <div class="flex items-center gap-3 rounded-xl border border-[#eff2f5] bg-[#f9f9f9] py-1.5 pr-3 pl-1.5">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-[#05443b] text-sm font-semibold text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <div class="hidden text-left sm:block">
                            <p class="text-sm leading-tight font-semibold">{{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-[#78829d]">Administrator</p>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 lg:p-8">
                @isset($subtitle)
                    <p class="mb-4 text-sm text-[#78829d]">{{ $subtitle }}</p>
                @endisset

                @if (session('success'))
                    <div class="mb-4 flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        <span class="font-semibold">Berhasil.</span> {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="border-t border-[#eff2f5] px-4 py-4 text-xs text-[#78829d] lg:px-8">
                <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                    <span>© {{ date('Y') }} {{ config('ponpes.name') }} — CMS Admin</span>
                    <span>Dibangun untuk pengelola konten pondok</span>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
