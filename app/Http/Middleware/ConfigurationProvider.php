<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Models\Configuration;
use App\Models\GifProvider;

class ConfigurationProvider implements IConfigurationProvider
{
    private $currentGifProvider;
    private $defaultConfiguration;

    function __construct()
    {
        $this->defaultConfiguration = $this->retrieveDefaultConfiguration();
        $this->currentGifProvider = $this->retrieveCurrentGifProvider();
    }

    public function getDefaultRequestProtocol() : string
    {
        return $this->defaultConfiguration->default_request_protocol;
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

    private function retrieveDefaultConfiguration()
    {
        return Configuration::where('default', true)->first();
    }

    private function retrieveCurrentGifProvider()
    {
        $currentGifProviderId = $this->defaultConfiguration->current_gif_provider;

        return GifProvider::where('identifier', $currentGifProviderId)->first();
    }
}