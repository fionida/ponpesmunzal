@extends('layouts.admin', ['title' => 'Program', 'heading' => 'Program Pendidikan', 'subtitle' => 'Kartu program di beranda & halaman pendidikan'])

@section('content')
<div x-data="{ selected: [], selectAll: false, toggleAll(ids){ this.selectAll=!this.selectAll; this.selected=this.selectAll?ids:[]; }, toggle(id){ this.selected=this.selected.includes(id)?this.selected.filter(i=>i!==id):[...this.selected,id]; this.selectAll=this.selected.length==={{ $items->count() }} && {{ $items->count() }}>0; } }">
@include('admin.partials.filter-bar', ['searchPlaceholder'=>'Cari program...','createUrl'=>route('admin.program.create'),'createLabel'=>'+ Tambah Program','filters'=>[['name'=>'status','label'=>'Status','all'=>'Semua','options'=>['aktif'=>'Aktif','nonaktif'=>'Nonaktif']]]])
@include('admin.partials.bulk-bar', ['bulkUrl'=>route('admin.program.bulk'),'bulkActions'=>['aktif'=>'Aktifkan','nonaktif'=>'Nonaktifkan','delete'=>'Hapus']])
<div class="metro-card overflow-hidden"><div class="overflow-x-auto">
<table class="metro-table w-full text-left text-sm">
<thead><tr>
<th class="w-10 px-4 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#1b84ff]" @click="toggleAll([{{ $items->pluck('id')->join(',') }}])" :checked="selectAll"></th>
<th class="w-14 px-3 py-3">No</th><th class="px-4 py-3">Program</th><th class="px-4 py-3">Urutan</th><th class="px-4 py-3">Status</th><th class="px-4 py-3"></th>
</tr></thead>
<tbody>
@forelse($items as $item)
<tr class="border-t border-[#eff2f5] hover:bg-[#f9f9f9]">
<td class="px-4 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#1b84ff]" :checked="selected.includes({{ $item->id }})" @change="toggle({{ $item->id }})"></td>
<td class="px-3 py-3 text-[#78829d]">{{ $items->firstItem()+$loop->index }}</td>
<td class="px-4 py-3"><div class="flex items-center gap-3"><img src="{{ $item->imageUrl() }}" class="h-12 w-16 rounded-lg object-cover"><div><p class="font-medium">{{ $item->title }}</p><p class="line-clamp-1 text-xs text-[#78829d]">{{ $item->description }}</p></div></div></td>
<td class="px-4 py-3">{{ $item->sort_order }}</td>
<td class="px-4 py-3"><span class="metro-badge {{ $item->is_active?'bg-emerald-50 text-emerald-700':'bg-slate-100 text-slate-600' }}">{{ $item->is_active?'Aktif':'Nonaktif' }}</span></td>
<td class="px-4 py-3 text-right whitespace-nowrap"><a href="{{ route('admin.program.edit',$item) }}" class="font-semibold text-[#1b84ff]">Edit</a>
<form action="{{ route('admin.program.destroy',$item) }}" method="POST" class="ml-3 inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="font-semibold text-red-500">Hapus</button></form></td>
</tr>
@empty<tr><td colspan="6" class="px-5 py-10 text-center text-[#78829d]">Belum ada program.</td></tr>@endforelse
</tbody></table></div></div>
<div class="mt-4">{{ $items->links() }}</div>
</div>
@endsection
