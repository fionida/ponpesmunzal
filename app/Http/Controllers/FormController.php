<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function contact(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email'],
            'whatsapp' => ['required', 'string', 'max:30'],
            'subjek' => ['required', 'string', 'max:80'],
            'pesan' => ['required', 'string', 'max:2000'],
        ]);

        ContactMessage::query()->create($data);

        return back()->with('success', 'Pesan Anda sudah kami terima. Tim pondok akan merespons dalam 1x24 jam.');
    }

    public function newsletter(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        return back()->with('newsletter', 'Terima kasih. Informasi terbaru akan kami kirimkan ke email Anda.');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'ttl' => ['required', 'string', 'max:120'],
            'wali' => ['required', 'string', 'max:120'],
            'whatsapp' => ['required', 'string', 'max:30'],
            'program' => ['required', 'string', 'max:80'],
        ]);

        Registration::query()->create($data);

        return back()->with('success', 'Pendaftaran awal berhasil dikirim. Panitia akan menghubungi wali santri.');
    }
}
