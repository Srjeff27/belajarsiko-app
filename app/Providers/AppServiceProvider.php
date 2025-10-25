<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL; // Import the URL facade
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request; // Import Request facade

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
    public function boot(Request $request): void // Inject Request for better practice
    {
        // 1. Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // 2. Set locale to Indonesian for Admin panel routes
        // Check if running in console (CLI) first, then check request path
        if (!$this->app->runningInConsole() && ($request->is('admin') || $request->is('admin/*'))) {
             app()->setLocale('id');
             // Optional: Set Carbon locale as well if you use it for dates
             \Carbon\Carbon::setLocale(app()->getLocale());
        }
    }
}