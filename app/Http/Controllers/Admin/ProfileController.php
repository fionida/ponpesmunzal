<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', [
            'profile' => SiteProfile::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $profile = SiteProfile::current();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'tagline' => ['nullable', 'string', 'max:120'],
            'motto' => ['nullable', 'string', 'max:255'],
            'about' => ['nullable', 'string'],
            'history' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'goals' => ['nullable', 'string'],
            'pengasuh_name' => ['nullable', 'string', 'max:120'],
            'pengasuh_title' => ['nullable', 'string', 'max:120'],
            'pengasuh_bio' => ['nullable', 'string'],
            'pengasuh_photo' => ['nullable', 'image', 'max:4096'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:120'],
            'hours' => ['nullable', 'string', 'max:120'],
            'stat_years' => ['nullable', 'string', 'max:20'],
            'stat_students' => ['nullable', 'string', 'max:20'],
            'stat_teachers' => ['nullable', 'string', 'max:20'],
            'stat_alumni' => ['nullable', 'string', 'max:20'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'map_embed' => ['nullable', 'string', 'max:500'],
            'features' => ['nullable', 'string'],
            'registration_docs' => ['nullable', 'string'],
            'registration_programs' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('pengasuh_photo')) {
            if ($profile->pengasuh_photo) {
                Storage::disk('public')->delete($profile->pengasuh_photo);
            }
            $data['pengasuh_photo'] = $request->file('pengasuh_photo')->store('profil', 'public');
        }

        $profile->update($data);

        return back()->with('success', 'Profil pondok berhasil disimpan.');
    }
}
