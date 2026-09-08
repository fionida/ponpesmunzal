<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteProfile extends Model
{
    protected $fillable = [
        'name',
        'tagline',
        'motto',
        'about',
        'history',
        'vision',
        'mission',
        'goals',
        'pengasuh_name',
        'pengasuh_title',
        'pengasuh_bio',
        'pengasuh_photo',
        'address',
        'phone',
        'whatsapp',
        'email',
        'hours',
        'stat_years',
        'stat_students',
        'stat_teachers',
        'stat_alumni',
        'youtube',
        'facebook',
        'instagram',
        'tiktok',
        'map_embed',
        'features',
        'registration_docs',
        'registration_programs',
    ];

    public static function current(): self
    {
        $profile = static::query()->first();

        if ($profile) {
            return $profile;
        }

        return static::query()->create([
            'name' => config('ponpes.name'),
            'tagline' => config('ponpes.tagline'),
            'motto' => config('ponpes.motto'),
            'address' => config('ponpes.address'),
            'phone' => config('ponpes.phone'),
            'whatsapp' => config('ponpes.whatsapp'),
            'email' => config('ponpes.email'),
            'hours' => config('ponpes.hours'),
            'stat_years' => '20+',
            'stat_students' => '1.500+',
            'stat_teachers' => '100+',
            'stat_alumni' => '10.000+',
            'pengasuh_name' => 'KH. Ahmad Fauzi, Lc.',
            'pengasuh_title' => 'Pengasuh Pondok Pesantren Nurul Huda',
        ]);
    }

    public function pengasuhPhotoUrl(): string
    {
        if ($this->pengasuh_photo) {
            return asset('storage/'.$this->pengasuh_photo);
        }

        return asset('images/pengasuh.jpg');
    }
}
