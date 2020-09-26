<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Interfaces\IDefaultGifProviderProxy;
use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Events\DefaultProviderChanged;
use App\Listeners\DefaultProviderChangedListener;

class DefaultGifProviderProxy extends DefaultProviderChangedListener implements IDefaultGifProviderProxy
{
    private $defaultProvider;
    private $configurationProvider;

    public function __construct(IConfigurationProvider $configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
        $this->defaultProvider = $configurationProvider->getGifProvider();
    }

    public function handle(DefaultProviderChanged $event)
    {
        $this->defaultProvider = $this->configurationProvider->getGifProvider();
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

    public function getCalls()
    {
        return $this->defaultProvider->calls;
    }
}