<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Listeners\DefaultProviderChangedListener;
use App\Events\DefaultProviderChanged;
use App\Models\Configuration;
use App\Models\GifProvider;

class ConfigurationProvider extends DefaultProviderChangedListener implements IConfigurationProvider
{
    private $currentGifProvider;
    private $defaultConfiguration;

    function __construct()
    {
        $this->defaultConfiguration = $this->retrieveDefaultConfiguration();
        $this->currentGifProvider = $this->retrieveCurrentGifProvider();
    }

    public function handle(DefaultProviderChanged $event)
    {
        $this->changeDefaultProvider($event->identifier);
    }

    public function getDefaultRequestProtocol() : string
    {
        return $this->defaultConfiguration->default_request_protocol;
    }

    public function getSanitationStrategy() : string
    {
        return $this->defaultConfiguration->sanitation_strategy;
    }

    public function getMaxResultsToShow() : int
    {
        return $this->defaultConfiguration->max_results_to_show;
    }

    public function getGifProvider()
    {
        return $this->currentGifProvider;
    }

    public function getSearchTermMinLength() : int
    {
        return $this->defaultConfiguration->search_term_min_length;
    }
    // TODO: rather than returning a 404 for those two methods, I should implement some custom
    // errohandling thing.
    private function retrieveDefaultConfiguration()
    {
        return Configuration::where('default', true)->firstOrFail();
    }

    private function changeDefaultProvider(string $identifier)
    {
        $this->currentGifProvider = $this->retrieveProvider($identifier);
        $this->defaultConfiguration->updateDefaultGifProvider($identifier);
    }

    private function retrieveCurrentGifProvider()
    {
        $currentGifProviderId = $this->defaultConfiguration->current_gif_provider;

        return $this->retrieveProvider($currentGifProviderId);
    }

    private function retrieveProvider(string $identifier)
    {
        return GifProvider::where('identifier', $identifier)->firstOrFail();
    }
}