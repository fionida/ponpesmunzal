<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = ['title', 'group', 'image', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function imageUrl(): string
    {
        return $this->image ? asset('storage/'.$this->image) : asset('images/classroom.jpg');
    }
}
