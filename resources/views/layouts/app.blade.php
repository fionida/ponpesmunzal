<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $meta ?? 'Pondok Pesantren Nurul Munzal — Ilmu, Adab, Manfaat. Pendidikan Qur’ani, berilmu, dan berakhlakul karimah.' }}">
    <title>{{ isset($title) ? $title.' | ' : '' }}{{ config('ponpes.name') }}</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</head>
<body class="bg-white text-ink antialiased" x-data="{ menuOpen: false, searchOpen: false }">
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.search-modal')
</body>
</html>
