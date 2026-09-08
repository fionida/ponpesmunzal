<section class="relative overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ $image }}" alt="" class="h-full w-full object-cover">
        <div class="absolute inset-0 bg-forest-deeper/55"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-forest-deeper/70 via-forest/35 to-transparent"></div>
    </div>

    <div class="container-site relative grid items-center gap-8 py-16 lg:grid-cols-[1.2fr_.8fr] lg:py-20">
        <div class="max-w-2xl text-white">
            <p class="text-sm text-white/80">Beranda <span class="mx-1.5">›</span> {{ $crumb }}</p>
            <h1 class="mt-4 font-serif text-4xl leading-tight font-semibold md:text-5xl">{{ $heading }}</h1>
            @if (!empty($text))
                <p class="mt-4 max-w-xl text-sm leading-relaxed text-white/85 md:text-base">{{ $text }}</p>
            @endif
        </div>

        @if (!empty($quote))
            <aside class="justify-self-end">
                <div class="max-w-sm rounded-2xl bg-white p-6 shadow-xl">
                    @if (!empty($quoteArabic))
                        <p class="font-arabic text-right text-xl leading-relaxed text-forest">{{ $quoteArabic }}</p>
                    @endif
                    <p class="mt-3 text-sm leading-relaxed text-ink">“{{ $quote }}”</p>
                    <p class="mt-3 text-xs font-semibold tracking-wide text-forest">{{ $quoteBy ?? '' }}</p>
                </div>
            </aside>
        @endif
    </div>
</section>
