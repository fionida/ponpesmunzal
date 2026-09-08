@extends('layouts.admin', ['title' => 'Pendaftaran', 'heading' => 'Pendaftaran Santri', 'subtitle' => 'Data calon santri dari formulir publik'])

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
        'searchPlaceholder' => 'Cari nama, wali, atau WhatsApp...',
        'filters' => [
            [
                'name' => 'status',
                'label' => 'Status',
                'all' => 'Semua status',
                'options' => [
                    'baru' => 'Baru',
                    'diproses' => 'Diproses',
                    'diterima' => 'Diterima',
                    'ditolak' => 'Ditolak',
                ],
            ],
        ],
    ])

    @include('admin.partials.bulk-bar', [
        'bulkUrl' => route('admin.pendaftaran.bulk'),
        'bulkActions' => [
            'diproses' => 'Tandai diproses',
            'diterima' => 'Tandai diterima',
            'ditolak' => 'Tandai ditolak',
            'baru' => 'Kembalikan ke baru',
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
                        <th class="px-4 py-3">Calon Santri</th>
                        <th class="px-4 py-3">Wali / WA</th>
                        <th class="px-4 py-3">Program</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Masuk</th>
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
                                <p class="font-medium text-[#252f4a]">{{ $item->nama }}</p>
                                <p class="text-xs text-[#78829d]">{{ $item->ttl }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p>{{ $item->wali }}</p>
                                <p class="text-xs text-[#78829d]">{{ $item->whatsapp }}</p>
                            </td>
                            <td class="px-4 py-3">{{ $item->program }}</td>
                            <td class="px-4 py-3"><span class="metro-badge bg-[#fff8dd] text-[#c59a00]">{{ $item->status }}</span></td>
                            <td class="px-4 py-3 text-[#78829d]">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.pendaftaran.show', $item) }}" class="font-semibold text-[#1b84ff]">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-10 text-center text-[#78829d]">Belum ada pendaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
@endsection
