@extends('layouts.admin', ['title' => 'Teks Halaman', 'heading' => 'Teks Halaman', 'subtitle' => 'Judul, kutipan, dan teks hero/CTA di setiap halaman publik'])

@section('content')
<form method="POST" action="{{ route('admin.konten.update') }}" class="space-y-5">
    @csrf @method('PUT')
    @forelse ($groups as $group => $items)
        <section class="metro-card overflow-hidden">
            <div class="border-b border-[#eff2f5] bg-[#f9f9f9] px-5 py-3">
                <h2 class="font-semibold capitalize">Halaman {{ $group }}</h2>
            </div>
            <div class="space-y-4 p-5">
                @foreach ($items as $item)
                    <label class="block text-sm">
                        <span class="mb-1.5 block font-medium">{{ $item->label }}</span>
                        @if ($item->type === 'text')
                            <input type="text" name="values[{{ $item->key }}]" value="{{ old('values.'.$item->key, $item->value) }}" class="metro-input">
                        @else
                            <textarea name="values[{{ $item->key }}]" rows="3" class="metro-input">{{ old('values.'.$item->key, $item->value) }}</textarea>
                        @endif
                        <span class="mt-1 block text-[11px] text-[#a1a5b7]">{{ $item->key }}</span>
                    </label>
                @endforeach
            </div>
        </section>
    @empty
        <div class="metro-card p-8 text-center text-[#78829d]">Belum ada konten. Jalankan seeder.</div>
    @endforelse
    @if ($groups->isNotEmpty())
        <button class="metro-btn">Simpan Semua Teks</button>
    @endif
</form>
@endsection
