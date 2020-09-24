<?php

namespace App\Providers;

use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Http\Middleware\ConfigurationProvider;
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
        $this->app->bind(
            IConfigurationProvider::class,
            ConfigurationProvider::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
