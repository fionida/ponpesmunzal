<?php

namespace App\Providers;

use App\Models\SiteProfile;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        View::composer('pages.*', function ($view): void {
            $images = collect(config('ponpes.images', []))
                ->map(fn (string $path): string => asset($path))
                ->all();

            $view->with('img', $images);

            if (! isset($view->getData()['profile'])) {
                try {
                    $view->with('profile', SiteProfile::current());
                } catch (\Throwable) {
                    // DB belum siap saat install awal
                }
            }
        });

        View::composer(['partials.footer', 'partials.header'], function ($view): void {
            try {
                $view->with('profile', SiteProfile::current());
            } catch (\Throwable) {
                //
            }
        });
    }
}
