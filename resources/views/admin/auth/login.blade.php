<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin | {{ config('ponpes.name') }}</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f5f8fa] antialiased">
    <div class="grid min-h-screen lg:grid-cols-2">
        {{-- Brand panel --}}
        <aside class="relative hidden overflow-hidden bg-[#1e1e2d] lg:flex lg:flex-col lg:justify-between lg:p-12 xl:p-16">
            <div class="absolute inset-0 opacity-40" style="background:
                radial-gradient(circle at 20% 20%, rgba(27,132,255,.35), transparent 45%),
                radial-gradient(circle at 80% 70%, rgba(5,68,59,.45), transparent 40%),
                linear-gradient(160deg, #1e1e2d 0%, #151521 100%);"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3">
                    @include('partials.logo', ['size' => 48])
                    <div>
                        <p class="text-lg font-semibold text-white">CMS Admin</p>
                        <p class="text-sm text-white/55">Panel pengelola konten</p>
                    </div>
                </div>
            </div>
            <div class="relative z-10 max-w-md">
                <p class="mb-3 text-xs font-semibold tracking-[0.2em] text-[#1b84ff] uppercase">Nurul Munzak</p>
                <h1 class="font-serif text-4xl leading-tight font-semibold text-white xl:text-5xl">
                    Kelola web pondok dengan mudah
                </h1>
                <p class="mt-4 text-sm leading-relaxed text-white/65">
                    Tulis berita, unggah galeri, perbarui profil, dan pantau pendaftaran santri dari satu tempat.
                </p>
                <div class="mt-10 grid grid-cols-3 gap-3">
                    @foreach ([['Berita', '▣'], ['Galeri', '▦'], ['Daftar', '✎']] as [$label, $icon])
                        <div class="rounded-xl border border-white/10 bg-white/5 px-3 py-4 text-center backdrop-blur">
                            <p class="text-lg text-white">{{ $icon }}</p>
                            <p class="mt-1 text-xs text-white/70">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <p class="relative z-10 text-xs text-white/40">© {{ date('Y') }} {{ config('ponpes.name') }}</p>
        </aside>

        {{-- Form panel --}}
        <main class="flex items-center justify-center p-6 sm:p-10">
            <div class="w-full max-w-[420px]">
                <div class="mb-8 flex items-center gap-3 lg:hidden">
                    @include('partials.logo', ['size' => 42])
                    <div>
                        <p class="font-semibold text-[#252f4a]">CMS Admin</p>
                        <p class="text-xs text-[#78829d]">{{ config('ponpes.short_name') }}</p>
                    </div>
                </div>

                <div class="metro-card p-7 sm:p-8">
                    <p class="text-xs font-semibold tracking-[0.16em] text-[#1b84ff] uppercase">Selamat datang</p>
                    <h2 class="mt-2 text-2xl font-semibold text-[#252f4a]">Masuk ke panel</h2>
                    <p class="mt-1.5 text-sm text-[#78829d]">Gunakan akun admin untuk mengelola konten situs.</p>

                    <form method="POST" action="{{ route('admin.login.submit') }}" class="mt-7 space-y-4">
                        @csrf
                        <label class="block text-sm">
                            <span class="mb-1.5 block font-medium text-[#252f4a]">Email</span>
                            <input type="email" name="email" value="{{ old('email', 'admin@munzal.ac.id') }}" required class="metro-input" autofocus placeholder="admin@email.com">
                        </label>
                        <label class="block text-sm">
                            <span class="mb-1.5 block font-medium text-[#252f4a]">Password</span>
                            <input type="password" name="password" required class="metro-input" placeholder="Masukkan password">
                        </label>
                        <div class="flex items-center justify-between pt-1">
                            <label class="flex items-center gap-2 text-sm text-[#78829d]">
                                <input type="checkbox" name="remember" value="1" class="rounded border-gray-300 text-[#1b84ff] focus:ring-[#1b84ff]">
                                Ingat saya
                            </label>
                            <a href="{{ route('beranda') }}" class="text-sm font-medium text-[#1b84ff] hover:underline">Lihat situs</a>
                        </div>
                        @error('email')
                            <div class="rounded-lg bg-red-50 px-3 py-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="metro-btn mt-2 w-full !py-3">
                            Masuk
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </button>
                    </form>
                </div>

                <p class="mt-6 text-center text-xs text-[#78829d]">
                    Default: <span class="font-medium text-[#252f4a]">admin@nurulmunzal.ac.id</span> / <span class="font-medium text-[#252f4a]">password</span>
                </p>
            </div>
        </main>
    </div>
</body>
</html>
