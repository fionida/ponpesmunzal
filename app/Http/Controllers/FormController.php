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
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir' => ['required', 'string', 'max:80'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string', 'max:500'],
            'sekolah_asal' => ['nullable', 'string', 'max:150'],
            'wali' => ['required', 'string', 'max:120'],
            'hubungan_wali' => ['required', 'string', 'max:40'],
            'whatsapp' => ['required', 'string', 'max:30'],
            'email_wali' => ['nullable', 'email', 'max:120'],
            'program' => ['required', 'string', 'max:80'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $ttl = $data['tempat_lahir'].', '.\Illuminate\Support\Carbon::parse($data['tanggal_lahir'])->translatedFormat('d F Y');

        Registration::query()->create([
            ...$data,
            'ttl' => $ttl,
        ]);

        return back()->with('success', 'Pendaftaran awal berhasil dikirim. Panitia akan menghubungi wali santri.');
    }
}
