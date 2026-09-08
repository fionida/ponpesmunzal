@extends('layouts.admin', ['title' => 'Berita', 'heading' => 'Kelola Berita', 'subtitle' => 'Tulis, edit, dan publish berita pondok'])

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
        this.selectAll = this.selected.length === {{ $posts->count() }} && {{ $posts->count() }} > 0;
    }
}">
    @include('admin.partials.filter-bar', [
        'searchPlaceholder' => 'Cari judul berita...',
        'createUrl' => route('admin.berita.create'),
        'createLabel' => '+ Tulis Berita',
        'filters' => [
            [
                'name' => 'status',
                'label' => 'Status',
                'all' => 'Semua status',
                'options' => ['published' => 'Published', 'draft' => 'Draft'],
            ],
        ],
    ])

    @include('admin.partials.bulk-bar', [
        'bulkUrl' => route('admin.berita.bulk'),
        'bulkActions' => [
            'publish' => 'Publish',
            'draft' => 'Jadikan draft',
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
                                @click="toggleAll([{{ $posts->pluck('id')->join(',') }}])"
                                :checked="selectAll">
                        </th>
                        <th class="w-14 px-3 py-3">No</th>
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr class="border-t border-[#eff2f5] hover:bg-[#f9f9f9]">
                            <td class="px-4 py-3">
                                <input type="checkbox" class="rounded border-gray-300 text-[#1b84ff]"
                                    :checked="selected.includes({{ $post->id }})"
                                    @change="toggle({{ $post->id }})">
                            </td>
                            <td class="px-3 py-3 text-[#78829d]">{{ $posts->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $post->coverUrl() }}" alt="" class="h-12 w-16 rounded-lg object-cover">
                                    <span class="font-medium text-[#252f4a]">{{ $post->title }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[#78829d]">{{ $post->category }}</td>
                            <td class="px-4 py-3">
                                <span class="metro-badge {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $post->status }}</span>
                            </td>
                            <td class="px-4 py-3 text-[#78829d]">{{ optional($post->published_at ?? $post->created_at)->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('admin.berita.edit', $post) }}" class="font-semibold text-[#1b84ff]">Edit</a>
                                <form action="{{ route('admin.berita.destroy', $post) }}" method="POST" class="ml-3 inline" onsubmit="return confirm('Hapus berita ini?')">
                                    @csrf @method('DELETE')
                                    <button class="font-semibold text-red-500">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-10 text-center text-[#78829d]">Belum ada berita.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $posts->links() }}</div>
</div>
@endsection
