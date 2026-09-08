{{-- Bulk action bar — requires Alpine parent: selected=[], toggleAll, etc. --}}
@php
    $bulkActions = $bulkActions ?? [];
    $bulkUrl = $bulkUrl ?? '#';
@endphp
<div
    x-show="selected.length > 0"
    x-cloak
    class="metro-card mb-4 flex flex-col gap-3 border-[#1b84ff]/20 bg-[#f1faff] p-3 sm:flex-row sm:items-center sm:justify-between"
>
    <p class="text-sm font-medium text-[#1b84ff]">
        <span x-text="selected.length"></span> item dipilih
    </p>
    <form method="POST" action="{{ $bulkUrl }}" class="flex flex-wrap items-center gap-2" @submit="if ($refs.bulkAction.value === 'delete' && !confirm('Hapus item terpilih?')) $event.preventDefault()">
        @csrf
        <template x-for="id in selected" :key="id">
            <input type="hidden" name="ids[]" :value="id">
        </template>
        <select name="action" x-ref="bulkAction" required class="metro-input !w-auto min-w-[180px] !py-2">
            <option value="">Pilih aksi...</option>
            @foreach ($bulkActions as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="metro-btn !py-2">Jalankan</button>
        <button type="button" class="rounded-lg px-3 py-2 text-sm font-semibold text-[#78829d] hover:bg-white" @click="selected = []; selectAll = false">Batal</button>
    </form>
</div>
