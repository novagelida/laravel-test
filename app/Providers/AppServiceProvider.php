<?php

namespace App\Providers;

use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Http\Middleware\ConfigurationProvider;
use App\Http\Middleware\Interfaces\IKeywordProxy;
use App\Http\Middleware\KeywordProxy;
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

        $this->app->bind(
            IKeywordProxy::class,
            KeywordProxy::class
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
