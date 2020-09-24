<?php

namespace App\Providers;

use App\Http\Middleware\BasicTenorResearchStrategy;
use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Http\Middleware\ConfigurationProvider;
use App\Http\Middleware\GifProviderProxy;
use App\Http\Middleware\Interfaces\IGifProviderProxy;
use App\Http\Middleware\Interfaces\IKeywordProxy;
use App\Http\Middleware\Interfaces\IResearchStrategy;
use App\Http\Middleware\Interfaces\ISearchResultFormatter;
use App\Http\Middleware\ToSimpleArraySearchResultFormatter;
use App\Http\Middleware\Helpers\SearchResultFormatterClassMapper;
use App\Http\Middleware\KeywordProxy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        IKeywordProxy::class => KeywordProxy::class,
        IGifProviderProxy::class => GifProviderProxy::class,
        ISearchResultFormatter::class => ToSimpleArraySearchResultFormatter::class,
        IResearchStrategy::class => BasicTenorResearchStrategy::class,
    ];

    public $singletons  = [
        IConfigurationProvider::class => ConfigurationProvider::class
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(IConfigurationProvider $configuration)
    {
        $this->app->bind(ISearchResultFormatter::class, SearchResultFormatterClassMapper::map($configuration->getFormatterName()));
        // TODO: if I register ISearchResultFormatter here, I can access the configuration provider
        // and decide wich concrete instance to register basing on what's on configuration.
        // I can do the same with IResearchStrategy basing on what's configured in gif_provider_table
    }
}
