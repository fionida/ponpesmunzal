<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'ttl',
        'alamat',
        'sekolah_asal',
        'wali',
        'hubungan_wali',
        'whatsapp',
        'email_wali',
        'program',
        'catatan',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function ttlDisplay(): string
    {
        if ($this->tempat_lahir || $this->tanggal_lahir) {
            $date = $this->tanggal_lahir?->translatedFormat('d F Y');

            return trim(($this->tempat_lahir ?? '').($date ? ', '.$date : ''), ', ');
        }

        return $this->ttl ?: '—';
    }
}
