@extends('layouts.admin', ['title' => 'Teks Halaman', 'heading' => 'Teks Halaman', 'subtitle' => 'Edit teks per halaman dan per section'])

@section('content')
@if (session('success'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
@endif

@if ($pages->isEmpty())
    <div class="metro-card p-8 text-center text-[#78829d]">Belum ada konten. Jalankan seeder.</div>
@else
    <div class="mb-5 flex flex-wrap gap-2">
        @foreach ($pages as $key => $label)
            <a
                href="{{ route('admin.konten.edit', ['halaman' => $key]) }}"
                class="rounded-lg px-4 py-2 text-sm font-medium transition {{ $active === $key ? 'bg-[#1b84ff] text-white shadow-sm' : 'bg-white text-[#252f4a] ring-1 ring-[#eff2f5] hover:bg-[#f9f9f9]' }}"
            >
                {{ $label }}
            </a>
        @endforeach
    </div>

    <form method="POST" action="{{ route('admin.konten.update') }}" class="space-y-4" x-data="{ open: '{{ $sections->first()['key'] ?? '' }}' }">
        @csrf @method('PUT')
        <input type="hidden" name="halaman" value="{{ $active }}">

        <div class="metro-card px-5 py-4">
            <p class="text-sm text-[#78829d]">Mengedit halaman</p>
            <h2 class="text-lg font-semibold text-[#252f4a]">{{ $pageLabel }}</h2>
            <p class="mt-1 text-xs text-[#a1a5b7]">Buka satu section, edit, lalu simpan. Section lain tetap tersimpan di database.</p>
        </div>

        @foreach ($sections as $section)
            <section class="metro-card overflow-hidden">
                <button
                    type="button"
                    class="flex w-full items-center justify-between gap-3 border-b border-[#eff2f5] bg-[#f9f9f9] px-5 py-3 text-left"
                    @click="open = open === '{{ $section['key'] }}' ? '' : '{{ $section['key'] }}'"
                >
                    <div>
                        <h3 class="font-semibold text-[#252f4a]">{{ $section['label'] }}</h3>
                        <p class="text-xs text-[#78829d]">{{ $section['items']->count() }} field</p>
                    </div>
                    <span class="text-[#78829d]" x-text="open === '{{ $section['key'] }}' ? '−' : '+'"></span>
                </button>

                <div class="space-y-4 p-5" x-show="open === '{{ $section['key'] }}'" x-cloak>
                    @foreach ($section['items'] as $item)
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
        @endforeach

        <div class="sticky bottom-4 z-10 flex justify-end">
            <button class="metro-btn shadow-lg">Simpan Teks {{ $pageLabel }}</button>
        </div>
    </form>
@endif
@endsection
