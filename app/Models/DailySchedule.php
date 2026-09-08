<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailySchedule extends Model
{
    protected $fillable = ['time', 'activity', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
