@extends('layouts.admin', ['title' => 'Galeri', 'heading' => 'Kelola Galeri', 'subtitle' => 'Foto dan video dokumentasi'])

@section('content')
<div x-data="{
    selected: [],
    selectAll: false,
    toggleAll(ids) {
        this.selectAll = !this.selectAll;
        this.selected = this.selectAll ? ids : [];
    },
    toggle(id) {
        if (this.selected.includes(id)) {
            this.selected = this.selected.filter(i => i !== id);
        } else {
            this.selected.push(id);
        }
        this.selectAll = this.selected.length === {{ $items->count() }} && {{ $items->count() }} > 0;
    }
}">
    @include('admin.partials.filter-bar', [
        'searchPlaceholder' => 'Cari judul galeri...',
        'createUrl' => route('admin.galeri.create'),
        'createLabel' => '+ Tambah Item',
        'filters' => [
            [
                'name' => 'type',
                'label' => 'Tipe',
                'all' => 'Semua tipe',
                'options' => ['foto' => 'Foto', 'video' => 'Video'],
            ],
            [
                'name' => 'category',
                'label' => 'Kategori',
                'all' => 'Semua kategori',
                'options' => [
                    'Kegiatan Harian' => 'Kegiatan Harian',
                    'Kegiatan Keagamaan' => 'Kegiatan Keagamaan',
                    'Kegiatan Akademik' => 'Kegiatan Akademik',
                    'Ekstrakurikuler' => 'Ekstrakurikuler',
                    'Sarana & Prasarana' => 'Sarana & Prasarana',
                    'Kunjungan Tamu' => 'Kunjungan Tamu',
                    'Prestasi' => 'Prestasi',
                ],
            ],
        ],
    ])

    @include('admin.partials.bulk-bar', [
        'bulkUrl' => route('admin.galeri.bulk'),
        'bulkActions' => [
            'feature' => 'Tandai unggulan',
            'unfeature' => 'Hapus unggulan',
            'delete' => 'Hapus',
        ],
    ])

    <div class="metro-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="metro-table w-full text-left text-sm">
                <thead>
                    <tr>
                        <th class="w-10 px-4 py-3">
                            <input type="checkbox" class="rounded border-gray-300 text-[#1b84ff]"
                                @click="toggleAll([{{ $items->pluck('id')->join(',') }}])"
                                :checked="selectAll">
                        </th>
                        <th class="w-14 px-3 py-3">No</th>
                        <th class="px-4 py-3">Item</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr class="border-t border-[#eff2f5] hover:bg-[#f9f9f9]">
                            <td class="px-4 py-3">
                                <input type="checkbox" class="rounded border-gray-300 text-[#1b84ff]"
                                    :checked="selected.includes({{ $item->id }})"
                                    @change="toggle({{ $item->id }})">
                            </td>
                            <td class="px-3 py-3 text-[#78829d]">{{ $items->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item->imageUrl() }}" alt="" class="h-12 w-16 rounded-lg object-cover">
                                    <div>
                                        <p class="font-medium">{{ $item->title }}</p>
                                        @if ($item->is_featured)
                                            <span class="metro-badge bg-amber-50 text-amber-700">Unggulan</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3"><span class="metro-badge bg-[#eef6ff] text-[#1b84ff]">{{ $item->type }}</span></td>
                            <td class="px-4 py-3 text-[#78829d]">{{ $item->category }}</td>
                            <td class="px-4 py-3 text-[#78829d]">{{ optional($item->taken_at)->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('admin.galeri.edit', $item) }}" class="font-semibold text-[#1b84ff]">Edit</a>
                                <form action="{{ route('admin.galeri.destroy', $item) }}" method="POST" class="ml-3 inline" onsubmit="return confirm('Hapus item ini?')">
                                    @csrf @method('DELETE')
                                    <button class="font-semibold text-red-500">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-10 text-center text-[#78829d]">Belum ada item galeri.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
@endsection
