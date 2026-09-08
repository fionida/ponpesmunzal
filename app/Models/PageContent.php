<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageContent extends Model
{
    protected $fillable = ['group', 'key', 'label', 'type', 'value'];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        $all = static::allMapped();

        return $all[$key] ?? $default;
    }

    public static function allMapped(): array
    {
        return Cache::remember('page_contents_map', 60, function () {
            return static::query()->pluck('value', 'key')->all();
        });
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('page_contents_map'));
        static::deleted(fn () => Cache::forget('page_contents_map'));
    }
}
