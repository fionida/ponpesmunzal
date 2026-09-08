@extends('layouts.admin', ['title' => 'Pesan Kontak', 'heading' => 'Pesan Kontak', 'subtitle' => 'Inbox dari formulir hubungi kami'])

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
        this.selectAll = this.selected.length === {{ $messages->count() }} && {{ $messages->count() }} > 0;
    }
}">
    @include('admin.partials.filter-bar', [
        'searchPlaceholder' => 'Cari nama, email, atau subjek...',
        'filters' => [
            [
                'name' => 'status',
                'label' => 'Status baca',
                'all' => 'Semua',
                'options' => ['baru' => 'Belum dibaca', 'dibaca' => 'Sudah dibaca'],
            ],
        ],
    ])

    @include('admin.partials.bulk-bar', [
        'bulkUrl' => route('admin.pesan.bulk'),
        'bulkActions' => [
            'read' => 'Tandai dibaca',
            'unread' => 'Tandai belum dibaca',
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
                                @click="toggleAll([{{ $messages->pluck('id')->join(',') }}])"
                                :checked="selectAll">
                        </th>
                        <th class="w-14 px-3 py-3">No</th>
                        <th class="px-4 py-3">Pengirim</th>
                        <th class="px-4 py-3">Subjek</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr class="border-t border-[#eff2f5] hover:bg-[#f9f9f9] {{ $message->is_read ? '' : 'bg-[#f1faff]/60' }}">
                            <td class="px-4 py-3">
                                <input type="checkbox" class="rounded border-gray-300 text-[#1b84ff]"
                                    :checked="selected.includes({{ $message->id }})"
                                    @change="toggle({{ $message->id }})">
                            </td>
                            <td class="px-3 py-3 text-[#78829d]">{{ $messages->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3">
                                <p class="font-medium">{{ $message->nama }}</p>
                                <p class="text-xs text-[#78829d]">{{ $message->email }}</p>
                            </td>
                            <td class="px-4 py-3">{{ $message->subjek }}</td>
                            <td class="px-4 py-3">
                                <span class="metro-badge {{ $message->is_read ? 'bg-slate-100 text-slate-600' : 'bg-[#eef6ff] text-[#1b84ff]' }}">
                                    {{ $message->is_read ? 'Dibaca' : 'Baru' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-[#78829d]">{{ $message->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.pesan.show', $message) }}" class="font-semibold text-[#1b84ff]">Buka</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-10 text-center text-[#78829d]">Belum ada pesan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $messages->links() }}</div>
</div>
@endsection
