<div x-show="searchOpen" x-cloak class="fixed inset-0 z-[60] flex items-start justify-center bg-forest-deeper/50 p-4 pt-28 backdrop-blur-sm" @keydown.escape.window="searchOpen = false">
    <div class="w-full max-w-xl rounded-2xl bg-white p-5 shadow-2xl" @click.outside="searchOpen = false">
        <form action="{{ route('berita') }}" method="GET" class="flex gap-2">
            <input type="search" name="q" placeholder="Cari berita, kegiatan, atau informasi..." class="input-field" autofocus>
            <button class="btn-forest !rounded-xl">Cari</button>
        </form>
    </div>
</div>
