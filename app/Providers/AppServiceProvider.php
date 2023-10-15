<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        //
        app()->bind('isMobile', function() {
            return (
                preg_match('/iPhone|iPad|iPod|Android/i', request()->header('User-Agent'))
            );
        });
    }
}
