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

    
        if (app()->environment('production')) {
        URL::forceScheme('https');
    }
    }
}
