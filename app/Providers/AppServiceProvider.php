<?php

namespace App\Providers;

use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Http\Middleware\ConfigurationProvider;
use App\Http\Middleware\DefaultGifProviderProxy;
use App\Http\Middleware\Interfaces\IGifProviderProxy;
use App\Http\Middleware\Interfaces\IKeywordProxy;
use App\Http\Middleware\Interfaces\IResearchStrategy;
use App\Http\Middleware\Interfaces\ISearchResultFormatter;
use App\Http\Middleware\Interfaces\IGifProvidersProxy;
use App\Http\Middleware\TenorResultToSimpleArrayFormatter;
use App\Http\Middleware\GifProvidersProxy;
use App\Http\Middleware\Helpers\SearchResultFormatterClassMapper;
use App\Http\Middleware\Helpers\ResearchStrategyClassMapper;
use App\Http\Middleware\Interfaces\ISanitationStrategy;
use App\Http\Middleware\KeywordProxy;
use App\Http\Middleware\Strategies\BasicSanitationStrategy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        IKeywordProxy::class => KeywordProxy::class,
        IGifProvidersProxy::class => GifProvidersProxy::class,
        ISearchResultFormatter::class => TenorResultToSimpleArrayFormatter::class,
        ISanitationStrategy::class => BasicSanitationStrategy::class
    ];

    public $singletons  = [
        IGifProviderProxy::class => DefaultGifProviderProxy::class,
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
        $this->app->bind(ISearchResultFormatter::class, SearchResultFormatterClassMapper::map($configuration->getGifProvider()->formatter));
        $this->app->bind(IResearchStrategy::class, ResearchStrategyClassMapper::map($configuration->getGifProvider()->research_strategy));
    }
}
