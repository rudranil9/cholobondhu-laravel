<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;

class HttpsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if (app()->environment('production')) {
            URL::forceScheme('https');
            
            // Set secure cookie settings
            config([
                'session.secure' => true,
                'session.same_site' => 'strict',
            ]);
        }

        // Fix for MySQL default string length
        Schema::defaultStringLength(191);
    }
}
