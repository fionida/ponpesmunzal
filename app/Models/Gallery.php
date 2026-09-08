<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'category',
        'type',
        'image',
        'video_url',
        'duration',
        'taken_at',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'taken_at' => 'date',
            'is_featured' => 'boolean',
        ];
    }

    public function imageUrl(): string
    {
        if ($this->image) {
            return asset('storage/'.$this->image);
        }

        return asset('images/students.jpg');
    }
}
