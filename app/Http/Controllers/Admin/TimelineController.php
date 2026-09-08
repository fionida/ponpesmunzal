<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimelineEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TimelineController extends Controller
{
    public function index(Request $request): View
    {
        $items = TimelineEvent::query()
            ->when($request->q, fn ($q, $s) => $q->where('title', 'like', "%{$s}%")->orWhere('year', 'like', "%{$s}%"))
            ->orderBy('sort_order')->orderBy('year')
            ->paginate(15)->withQueryString();

        return view('admin.timelines.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.timelines.form', ['item' => new TimelineEvent]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active', true);
        TimelineEvent::query()->create($data);

        return redirect()->route('admin.timeline.index')->with('success', 'Timeline ditambahkan.');
    }

    public function edit(TimelineEvent $timeline): View
    {
        return view('admin.timelines.form', ['item' => $timeline]);
    }

    public function update(Request $request, TimelineEvent $timeline): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $timeline->update($data);

        return redirect()->route('admin.timeline.index')->with('success', 'Timeline diperbarui.');
    }

    public function destroy(TimelineEvent $timeline): RedirectResponse
    {
        $timeline->delete();

        return back()->with('success', 'Timeline dihapus.');
    }

    public function bulk(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:timeline_events,id'],
            'action' => ['required', 'in:delete'],
        ]);
        TimelineEvent::query()->whereIn('id', $data['ids'])->delete();

        return back()->with('success', count($data['ids']).' timeline dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'year' => ['required', 'string', 'max:20'],
            'title' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
