<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Import ini di paling atas
use Illuminate\Support\Facades\URL; // Import ini di paling atas file
use Illuminate\Support\Facades\Config; // Import ini juga


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        Paginator::useTailwind();

        // Paksa HTTPS jika APP_ENV di set ke 'production' (seperti di Railway)
        if (Config::get('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
