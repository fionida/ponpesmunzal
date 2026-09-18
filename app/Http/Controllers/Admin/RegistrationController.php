<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $items = Registration::query()
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->when($request->q, function ($q, $search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('nama', 'like', "%{$search}%")
                        ->orWhere('wali', 'like', "%{$search}%")
                        ->orWhere('whatsapp', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.registrations.index', compact('items'));
    }

    public function show(Registration $pendaftaran): View
    {
        return view('admin.registrations.show', ['item' => $pendaftaran]);
    }

    public function update(Request $request, Registration $pendaftaran): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'jenis_kelamin' => ['nullable', 'in:Laki-laki,Perempuan'],
            'tempat_lahir' => ['nullable', 'string', 'max:80'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'sekolah_asal' => ['nullable', 'string', 'max:150'],
            'wali' => ['required', 'string', 'max:120'],
            'hubungan_wali' => ['nullable', 'string', 'max:40'],
            'whatsapp' => ['required', 'string', 'max:30'],
            'email_wali' => ['nullable', 'email', 'max:120'],
            'program' => ['required', 'string', 'max:80'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:baru,diproses,diterima,ditolak'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        if (! empty($data['tempat_lahir']) && ! empty($data['tanggal_lahir'])) {
            $data['ttl'] = $data['tempat_lahir'].', '.\Illuminate\Support\Carbon::parse($data['tanggal_lahir'])->translatedFormat('d F Y');
        }

        $pendaftaran->update($data);

        return back()->with('success', 'Data pendaftaran diperbarui.');
    }

    public function destroy(Registration $pendaftaran): RedirectResponse
    {
        $pendaftaran->delete();

        return redirect()->route('admin.pendaftaran.index')->with('success', 'Data pendaftaran dihapus.');
    }

    public function bulk(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:registrations,id'],
            'action' => ['required', 'in:delete,baru,diproses,diterima,ditolak'],
        ]);

        if ($data['action'] === 'delete') {
            Registration::query()->whereIn('id', $data['ids'])->delete();

            return back()->with('success', count($data['ids']).' pendaftaran dihapus.');
        }

        Registration::query()->whereIn('id', $data['ids'])->update([
            'status' => $data['action'],
        ]);

        return back()->with('success', count($data['ids']).' status diperbarui.');
    }
}
