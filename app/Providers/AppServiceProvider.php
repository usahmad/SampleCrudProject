<?php

namespace App\Providers;

use App\Functionality\Constants;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('permission', function ($value) {
            return auth()->user()->hasPermission($value) && !in_array($value, Constants::excludedRoutes);
        });
    }
}
