@extends('layouts.admin', ['title' => 'FAQ', 'heading' => 'FAQ', 'subtitle' => 'Pertanyaan di halaman kontak'])
@section('content')
<div x-data="{ selected: [], selectAll: false, toggleAll(ids){ this.selectAll=!this.selectAll; this.selected=this.selectAll?ids:[]; }, toggle(id){ this.selected=this.selected.includes(id)?this.selected.filter(i=>i!==id):[...this.selected,id]; this.selectAll=this.selected.length==={{ $items->count() }} && {{ $items->count() }}>0; } }">
@include('admin.partials.filter-bar', ['searchPlaceholder'=>'Cari pertanyaan...','createUrl'=>route('admin.faq.create'),'createLabel'=>'+ Tambah FAQ','filters'=>[]])
@include('admin.partials.bulk-bar', ['bulkUrl'=>route('admin.faq.bulk'),'bulkActions'=>['aktif'=>'Aktifkan','nonaktif'=>'Nonaktifkan','delete'=>'Hapus']])
<div class="metro-card overflow-hidden"><div class="overflow-x-auto"><table class="metro-table w-full text-left text-sm">
<thead><tr><th class="w-10 px-4 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#1b84ff]" @click="toggleAll([{{ $items->pluck('id')->join(',') }}])" :checked="selectAll"></th><th class="w-14 px-3 py-3">No</th><th class="px-4 py-3">Pertanyaan</th><th class="px-4 py-3">Urutan</th><th class="px-4 py-3"></th></tr></thead>
<tbody>
@forelse($items as $item)
<tr class="border-t border-[#eff2f5] hover:bg-[#f9f9f9]">
<td class="px-4 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#1b84ff]" :checked="selected.includes({{ $item->id }})" @change="toggle({{ $item->id }})"></td>
<td class="px-3 py-3 text-[#78829d]">{{ $items->firstItem()+$loop->index }}</td>
<td class="px-4 py-3"><p class="font-medium">{{ $item->question }}</p><p class="line-clamp-1 text-xs text-[#78829d]">{{ $item->answer }}</p></td>
<td class="px-4 py-3">{{ $item->sort_order }}</td>
<td class="px-4 py-3 text-right"><a href="{{ route('admin.faq.edit',$item) }}" class="font-semibold text-[#1b84ff]">Edit</a>
<form action="{{ route('admin.faq.destroy',$item) }}" method="POST" class="ml-3 inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="font-semibold text-red-500">Hapus</button></form></td>
</tr>
@empty<tr><td colspan="5" class="px-5 py-10 text-center text-[#78829d]">Belum ada FAQ.</td></tr>@endforelse
</tbody></table></div></div>
<div class="mt-4">{{ $items->links() }}</div></div>
@endsection
