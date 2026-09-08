<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailySchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(Request $request): View
    {
        $items = DailySchedule::query()
            ->when($request->q, fn ($q, $s) => $q->where('activity', 'like', "%{$s}%")->orWhere('time', 'like', "%{$s}%"))
            ->orderBy('sort_order')->orderBy('id')
            ->paginate(20)->withQueryString();

        return view('admin.schedules.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.schedules.form', ['item' => new DailySchedule]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active', true);
        DailySchedule::query()->create($data);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal ditambahkan.');
    }

    public function edit(DailySchedule $jadwal): View
    {
        return view('admin.schedules.form', ['item' => $jadwal]);
    }

    public function update(Request $request, DailySchedule $jadwal): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $jadwal->update($data);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal diperbarui.');
    }

    public function destroy(DailySchedule $jadwal): RedirectResponse
    {
        $jadwal->delete();

        return back()->with('success', 'Jadwal dihapus.');
    }

    public function bulk(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:daily_schedules,id'],
            'action' => ['required', 'in:delete'],
        ]);
        DailySchedule::query()->whereIn('id', $data['ids'])->delete();

        return back()->with('success', count($data['ids']).' jadwal dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'time' => ['required', 'string', 'max:20'],
            'activity' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
