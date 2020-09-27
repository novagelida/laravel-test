<?php

namespace App\Providers;

use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Http\Middleware\ConfigurationProvider;
use App\Http\Middleware\DefaultGifProviderProxy;
use App\Http\Middleware\Interfaces\IDefaultGifProviderProxy;
use App\Http\Middleware\Interfaces\IKeywordProxy;
use App\Http\Middleware\Interfaces\IResearchStrategy;
use App\Http\Middleware\Interfaces\ISearchResultFormatter;
use App\Http\Middleware\Interfaces\IGifProvidersProxy;
use App\Http\Middleware\Interfaces\IConfigurationProxy;
use App\Http\Middleware\GifProvidersProxy;
use App\Http\Middleware\ConfigurationProxy;
use App\Http\Middleware\Helpers\SearchResultFormatterClassMapper;
use App\Http\Middleware\Helpers\ResearchStrategyClassMapper;
use App\Http\Middleware\Helpers\SanitationStrategyClassMapper;
use App\Http\Middleware\Interfaces\ISanitationStrategy;
use App\Http\Middleware\KeywordProxy;
use App\Http\Middleware\Strategies\BasicSanitationStrategy;
use App\Http\Controllers\SearchController;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        IKeywordProxy::class => KeywordProxy::class,
        IGifProvidersProxy::class => GifProvidersProxy::class,
        ISanitationStrategy::class => BasicSanitationStrategy::class,
        IConfigurationProxy::class => ConfigurationProxy::class
    ];

    public $singletons  = [
        IDefaultGifProviderProxy::class => DefaultGifProviderProxy::class,
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
        $this->app->when(SearchController::class)
             ->needs(ISearchResultFormatter::class)
             ->give(function () use ($configuration){
                 $class = SearchResultFormatterClassMapper::map($configuration->getGifProvider()->formatter);
                 return resolve($class);
             });

        $this->app->when(SearchController::class)
             ->needs(IResearchStrategy::class)
             ->give(function () use ($configuration){
                 $class = ResearchStrategyClassMapper::map($configuration->getGifProvider()->research_strategy);
                 return resolve($class);
             });
             
        $this->app->bind(ISanitationStrategy::class, SanitationStrategyClassMapper::map($configuration->getSanitationStrategy()));
    }
}
