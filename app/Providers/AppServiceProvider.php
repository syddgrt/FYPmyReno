<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

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
        require_once app_path('Http/Helpers.php');

        View::composer('layouts.navigation', function ($view) {
            if (!Auth::guest()) { // Check if the user is authenticated
                $userRole = Auth::user()->role; // Adjust based on your application
                $view->with('userRole', $userRole);
            }
        });
    }
}
