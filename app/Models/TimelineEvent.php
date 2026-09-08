<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelineEvent extends Model
{
    protected $fillable = ['year', 'title', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
