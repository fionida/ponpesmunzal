<footer class="bg-forest-deeper text-white">
    <div class="container-site grid gap-10 py-14 md:grid-cols-2 lg:grid-cols-4">
        <div>
            <div class="flex items-center gap-3">
                @include('partials.logo', ['size' => 44])
                <div>
                    <p class="font-semibold">{{ $profile->name ?? config('ponpes.name') }}</p>
                    <p class="text-xs text-white/70">{{ $profile->tagline ?? config('ponpes.tagline') }}</p>
                </div>
            </div>
            <p class="mt-4 max-w-xs text-sm leading-relaxed text-white/70">
                {{ $profile->about ? \Illuminate\Support\Str::limit(strip_tags($profile->about), 140) : 'Lembaga pendidikan Islam yang menumbuhkan generasi berilmu, beradab, dan bermanfaat bagi umat.' }}
            </p>
            <div class="mt-5 flex gap-2">
                @foreach (['youtube','facebook','instagram','tiktok'] as $sos)
                    <a href="{{ $profile->$sos ?? '#' }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/15 text-white/80 hover:bg-white/10" aria-label="{{ ucfirst($sos) }}">
                        <span class="text-[11px] font-semibold uppercase">{{ substr($sos, 0, 2) }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <div>
            <h3 class="mb-4 text-sm font-semibold tracking-wide">Menu Utama</h3>
            <ul class="space-y-2.5 text-sm text-white/75">
                <li><a class="hover:text-white" href="{{ route('beranda') }}">Beranda</a></li>
                <li><a class="hover:text-white" href="{{ route('profil') }}">Profil</a></li>
                <li><a class="hover:text-white" href="{{ route('pendidikan') }}">Pendidikan</a></li>
                <li><a class="hover:text-white" href="{{ route('kegiatan') }}">Kegiatan</a></li>
                <li><a class="hover:text-white" href="{{ route('berita') }}">Berita</a></li>
                <li><a class="hover:text-white" href="{{ route('galeri') }}">Galeri</a></li>
                <li><a class="hover:text-white" href="{{ route('kontak') }}">Kontak</a></li>
            </ul>
        </div>

        <div>
            <h3 class="mb-4 text-sm font-semibold tracking-wide">Kontak Kami</h3>
            <ul class="space-y-3 text-sm text-white/75">
                <li>{{ $profile->address ?? config('ponpes.address') }}</li>
                <li>{{ $profile->phone ?? config('ponpes.phone') }} · {{ $profile->whatsapp ?? config('ponpes.whatsapp') }}</li>
                <li>{{ $profile->email ?? config('ponpes.email') }}</li>
            </ul>
        </div>

        <div>
            <h3 class="mb-4 text-sm font-semibold tracking-wide">Dapatkan Informasi Terbaru</h3>
            <p class="mb-3 text-sm text-white/70">Berita kegiatan, pengumuman, dan info pendaftaran.</p>
            @if (session('newsletter'))
                <p class="rounded-lg bg-white/10 px-3 py-2 text-sm text-gold">{{ session('newsletter') }}</p>
            @else
                <form action="{{ route('newsletter.submit') }}" method="POST" class="relative">
                    @csrf
                    <input type="email" name="email" required placeholder="Alamat email Anda" class="w-full rounded-full border-0 bg-white py-3 pr-12 pl-4 text-sm text-ink outline-none">
                    <button type="submit" class="absolute top-1 right-1 inline-flex h-9 w-9 items-center justify-center rounded-full bg-forest text-white" aria-label="Kirim">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-site flex flex-col gap-3 py-4 text-xs text-white/60 sm:flex-row sm:items-center sm:justify-between">
            <p>© {{ date('Y') }} {{ config('ponpes.name') }}. Semua hak dilindungi.</p>
            <div class="flex gap-5">
                <a href="{{ route('kontak') }}" class="hover:text-white">Kebijakan Privasi</a>
                <a href="{{ route('kontak') }}" class="hover:text-white">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>
