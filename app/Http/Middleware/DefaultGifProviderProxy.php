<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Interfaces\IGifProviderProxy;
use App\Http\Middleware\Interfaces\IConfigurationProvider;

class DefaultGifProviderProxy implements IGifProviderProxy
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

    public function incrementCalls()
    {
        $this->defaultProvider->incrementCalls();
    }

    public function getKeywords()
    {
        return $this->defaultProvider->keyword()->select('keyword_value', 'call_counter')->get();
    }

    public function getCalls()
    {
        return $this->defaultProvider->calls;
    }
}