<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Interfaces\IGifProviderProxy;
use App\Http\Middleware\Interfaces\IConfigurationProvider;

class GifProviderProxy implements IGifProviderProxy
{
    private $defaultProvider;

    public function __construct(IConfigurationProvider $configurationProvider)
    {
        $this->defaultProvider = $configurationProvider->getGifProvider();
    }

    public function getDefaultGifProvider()
    {
        return $this->defaultProvider;
    }

    public function getCredentials()
    {
        return json_decode($this->defaultProvider->credentials);
    }

    public function getResearchDomain() : string
    {
        return $this->defaultProvider->research_endpoint;
    }

    public function incrementCalls(string $keyword)
    {
        $this->incrementProviderCalls($this->defaultProvider);
    }

    private function incrementProviderCalls($provider)
    {
        $provider->calls = $provider->calls+1;
        $provider->save();
    }
}