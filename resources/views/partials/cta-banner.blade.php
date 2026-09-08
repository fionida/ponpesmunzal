<section class="bg-forest pattern-geom">
    <div class="container-site flex flex-col items-start justify-between gap-6 py-12 md:flex-row md:items-center">
        <div class="flex items-start gap-4 text-white">
            <div class="hidden h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/10 sm:flex">
                {!! $icon ?? '<svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path d="M4 19a4 4 0 014-4h8a4 4 0 014 4M8 7a4 4 0 118 0 4 4 0 01-8 0z"/></svg>' !!}
            </div>
            <div>
                <h2 class="font-serif text-2xl font-semibold md:text-3xl">{{ $heading }}</h2>
                @if (!empty($text))
                    <p class="mt-2 max-w-xl text-sm text-white/80">{{ $text }}</p>
                @endif
            </div>
        </div>
        <a href="{{ $href ?? route('pendaftaran') }}" class="btn-gold shrink-0">
            {{ $button ?? 'Daftar Sekarang' }}
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
    </div>
</section>
