@extends('layouts.app', ['title' => 'Kontak'])

@section('content')
@include('partials.page-hero', [
    'image' => $img['campus'],
    'crumb' => 'Kontak',
    'heading' => $contents['kontak.hero_title'] ?? 'Hubungi Kami',
    'text' => $contents['kontak.hero_text'] ?? 'Silaturahmi, pertanyaan pendaftaran, kerja sama, dan saran sangat kami buka.',
    'quote' => $contents['kontak.quote'] ?? 'Tolong-menolonglah kamu dalam (mengerjakan) kebajikan dan takwa.',
    'quoteArabic' => $contents['kontak.quote_ar'] ?? 'وَتَعَاوَنُوا عَلَى الْبِرِّ وَالتَّقْوَىٰ',
    'quoteBy' => $contents['kontak.quote_by'] ?? 'QS. Al-Ma’idah: 2',
])

<section class="relative z-10 -mt-8">
    <div class="container-site grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            ['Alamat', $profile->address ?: config('ponpes.address')],
            ['Telepon', trim(($profile->phone ?: config('ponpes.phone')).' · '.($profile->whatsapp ?: config('ponpes.whatsapp')))],
            ['Email', $profile->email ?: config('ponpes.email')],
            ['Jam Operasional', $profile->hours ?: config('ponpes.hours')],
        ] as $c)
            <div class="card-soft p-5">
                <h3 class="font-semibold text-forest">{{ $c[0] }}</h3>
                <p class="mt-2 text-sm leading-relaxed text-muted">{{ $c[1] }}</p>
            </div>
        @endforeach
    </div>
</section>

<section class="py-16">
    <div class="container-site grid items-start gap-10 lg:grid-cols-[1fr_.9fr]">
        <div>
            <p class="mb-2 h-1 w-10 rounded-full bg-forest"></p>
            <h2 class="font-serif text-3xl font-semibold">{{ $contents['kontak.form_title'] ?? 'Formulir Kontak' }}</h2>
            @if (session('success'))
                <p class="mt-4 rounded-xl bg-sand px-4 py-3 text-sm text-forest">{{ session('success') }}</p>
            @endif
            <form action="{{ route('kontak.submit') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Nama Lengkap</span>
                        <input name="nama" value="{{ old('nama') }}" required class="input-field" placeholder="Nama Anda">
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required class="input-field" placeholder="email@contoh.com">
                    </label>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Nomor WhatsApp</span>
                        <input name="whatsapp" value="{{ old('whatsapp') }}" required class="input-field" placeholder="08xx">
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">Subjek</span>
                        <select name="subjek" class="input-field">
                            @foreach (preg_split('/\r\n|\r|\n/', $contents['kontak.subjects'] ?? "Pertanyaan Pendaftaran\nKerja Sama\nSaran & Masukan\nLainnya") as $opt)
                                @if (trim($opt) !== '')
                                    <option {{ old('subjek') === trim($opt) ? 'selected' : '' }}>{{ trim($opt) }}</option>
                                @endif
                            @endforeach
                        </select>
                    </label>
                </div>
                <label class="block text-sm">
                    <span class="mb-1.5 block font-medium">Pesan</span>
                    <textarea name="pesan" rows="5" required class="input-field" placeholder="Tulis pesan Anda">{{ old('pesan') }}</textarea>
                </label>
                @if ($errors->any())
                    <p class="text-sm text-red-600">{{ $errors->first() }}</p>
                @endif
                <button class="btn-forest">Kirim Pesan →</button>
            </form>
        </div>
        <div>
            <div class="relative overflow-hidden rounded-3xl">
                <img src="{{ $img['campus'] }}" alt="Gedung pondok" class="h-80 w-full object-cover">
                <div class="absolute right-0 bottom-0 left-0 bg-forest/90 p-5 text-sm text-white">
                    “{{ $contents['kontak.aside_quote'] ?? 'Silaturahmi adalah jembatan menuju keberkahan dan kemajuan bersama.' }}”
                </div>
            </div>
            <div class="mt-4 space-y-3">
                @foreach (preg_split('/\r\n|\r|\n/', $contents['kontak.help_items'] ?? "Pertanyaan Seputar Pendaftaran|Jadwal, syarat, dan program yang sesuai.\nKerja Sama|Kunjungan, pengajian, dan kolaborasi lembaga.\nSaran & Masukan|Kami terbuka merawat mutu pelayanan pondok.") as $line)
                    @php $parts = array_map('trim', explode('|', $line, 2)); @endphp
                    @if (($parts[0] ?? '') !== '')
                        <div class="rounded-2xl bg-mist p-4">
                            <h3 class="font-semibold text-forest">{{ $parts[0] }}</h3>
                            <p class="text-sm text-muted">{{ $parts[1] ?? '' }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="bg-mist py-16">
    <div class="container-site grid gap-8 lg:grid-cols-3">
        <div>
            <h2 class="font-serif text-2xl font-semibold">Lokasi Kami</h2>
            <p class="mt-2 mb-4 text-sm text-muted">{{ $profile->address ?: config('ponpes.address') }}</p>
            <div class="overflow-hidden rounded-2xl">
                @if ($profile->map_embed)
                    @if (str_contains($profile->map_embed, '<iframe'))
                        {!! $profile->map_embed !!}
                    @else
                        <iframe class="h-56 w-full" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="{{ $profile->map_embed }}"></iframe>
                    @endif
                @else
                    <iframe class="h-56 w-full" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q=Malang%20Jawa%20Timur&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
                @endif
            </div>
            <a href="https://maps.google.com/?q={{ urlencode($profile->address ?: 'Malang Jawa Timur') }}" target="_blank" class="mt-3 inline-flex text-sm font-semibold text-forest">Buka di Google Maps →</a>
        </div>
        <div>
            <h2 class="font-serif text-2xl font-semibold">Akses & Transportasi</h2>
            <ul class="mt-4 space-y-3 text-sm">
                @foreach (preg_split('/\r\n|\r|\n/', $contents['kontak.transport'] ?? "Kendaraan Pribadi|Dari pusat kota Malang sekitar 20–30 menit.\nAngkutan Umum|Naik angkot atau bus kota menuju Lowokwaru.\nBandara|Dari Bandara Abd. Saleh sekitar 25 menit.\nStasiun|Dari Stasiun Malang Kota sekitar 20 menit.") as $line)
                    @php $parts = array_map('trim', explode('|', $line, 2)); @endphp
                    @if (($parts[0] ?? '') !== '')
                        <li class="rounded-2xl bg-white p-4">
                            <p class="font-semibold text-forest">{{ $parts[0] }}</p>
                            <p class="text-muted">{{ $parts[1] ?? '' }}</p>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div x-data="{ open: 0 }">
            <h2 class="font-serif text-2xl font-semibold">Pertanyaan yang Sering Diajukan</h2>
            <div class="mt-4 space-y-2">
                @forelse (($faqs ?? collect()) as $i => $faq)
                    <div class="rounded-2xl bg-white">
                        <button type="button" class="flex w-full items-center justify-between px-4 py-3 text-left text-sm font-semibold" @click="open = open === {{ $i }} ? null : {{ $i }}">
                            {{ $faq->question }}
                            <span>+</span>
                        </button>
                        <p class="px-4 pb-3 text-sm text-muted" x-show="open === {{ $i }}" x-cloak>{{ $faq->answer }}</p>
                    </div>
                @empty
                    <p class="text-sm text-muted">Belum ada FAQ. Tambahkan lewat admin.</p>
                @endforelse
            </div>
            <a href="{{ route('pendaftaran') }}" class="mt-4 inline-flex text-sm font-semibold text-forest">Lihat Pendaftaran →</a>
        </div>
    </div>
</section>

@include('partials.cta-banner', [
    'heading' => $contents['kontak.cta_title'] ?? 'Mari Terhubung dan Bersinergi',
    'text' => $contents['kontak.cta_text'] ?? 'Tim pondok siap membantu pertanyaan pendaftaran dan kerja sama.',
    'button' => $contents['kontak.cta_button'] ?? 'Hubungi Kami Sekarang',
    'href' => route('kontak'),
])
@endsection
