{{-- Professional filter toolbar --}}
@php
    $filters = $filters ?? [];
    $action = $action ?? url()->current();
    $createUrl = $createUrl ?? null;
    $createLabel = $createLabel ?? '+ Tambah';
@endphp
<div class="metro-card mb-5 p-4">
    <form method="GET" action="{{ $action }}" class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div class="grid flex-1 gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <label class="block text-sm">
                <span class="mb-1.5 block text-xs font-semibold tracking-wide text-[#78829d] uppercase">Pencarian</span>
                <div class="relative">
                    <svg class="pointer-events-none absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-[#a1a5b7]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3-3"/></svg>
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ $searchPlaceholder ?? 'Cari...' }}" class="metro-input !pl-10">
                </div>
            </label>
            @foreach ($filters as $filter)
                <label class="block text-sm">
                    <span class="mb-1.5 block text-xs font-semibold tracking-wide text-[#78829d] uppercase">{{ $filter['label'] }}</span>
                    <select name="{{ $filter['name'] }}" class="metro-input" onchange="this.form.submit()">
                        <option value="">{{ $filter['all'] ?? 'Semua' }}</option>
                        @foreach ($filter['options'] as $value => $label)
                            <option value="{{ $value }}" @selected((string) request($filter['name']) === (string) $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
            @endforeach
        </div>
        <div class="flex shrink-0 flex-wrap gap-2">
            <button type="submit" class="metro-btn">Terapkan</button>
            <a href="{{ $action }}" class="inline-flex items-center rounded-lg border border-[#eff2f5] bg-white px-4 py-2.5 text-sm font-semibold text-[#78829d] hover:bg-[#f5f8fa]">Reset</a>
            @if ($createUrl)
                <a href="{{ $createUrl }}" class="metro-btn-dark">{{ $createLabel }}</a>
            @endif
        </div>
    </form>
</div>
