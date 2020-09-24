<?php

namespace App\Providers;

use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Http\Middleware\ConfigurationProvider;
use App\Http\Middleware\GifProviderProxy;
use App\Http\Middleware\Interfaces\IGifProviderProxy;
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

        $this->app->bind(
            IGifProviderProxy::class,
            GifProviderProxy::class
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
