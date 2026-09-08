<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $messages = ContactMessage::query()
            ->when($request->q, function ($q, $search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('subjek', 'like', "%{$search}%");
                });
            })
            ->when($request->status === 'baru', fn ($q) => $q->where('is_read', false))
            ->when($request->status === 'dibaca', fn ($q) => $q->where('is_read', true))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $pesan): View
    {
        if (! $pesan->is_read) {
            $pesan->update(['is_read' => true]);
        }

        return view('admin.messages.show', ['message' => $pesan]);
    }

    public function destroy(ContactMessage $pesan): RedirectResponse
    {
        $pesan->delete();

        return redirect()->route('admin.pesan.index')->with('success', 'Pesan dihapus.');
    }

    public function bulk(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:contact_messages,id'],
            'action' => ['required', 'in:delete,read,unread'],
        ]);

        if ($data['action'] === 'delete') {
            ContactMessage::query()->whereIn('id', $data['ids'])->delete();

            return back()->with('success', count($data['ids']).' pesan dihapus.');
        }

        ContactMessage::query()->whereIn('id', $data['ids'])->update([
            'is_read' => $data['action'] === 'read',
        ]);

        return back()->with('success', count($data['ids']).' pesan diperbarui.');
    }
}
