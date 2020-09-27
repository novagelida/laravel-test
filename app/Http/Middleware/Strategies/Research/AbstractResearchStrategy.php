<?php

namespace App\Http\Middleware\Strategies\Research;

use App\Http\Middleware\Interfaces\IResearchStrategy;
use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Http\Middleware\Interfaces\IDefaultGifProviderProxy;
use Illuminate\Support\Facades\Http;

abstract class AbstractResearchStrategy implements IResearchStrategy
{
    private const ERROR_MESSAGE = "Something went wrong in performing your research";

    private $configuration;
    private $gifProviderProxy;

    public function __construct(IConfigurationProvider $configurationProvider,
                                IDefaultGifProviderProxy $gifProviderProxy)
    {
        $this->configuration = $configurationProvider;
        $this->gifProviderProxy = $gifProviderProxy;
    }

    public function search(string $keyword) : string
    {
        $defaultProtocol = $this->configuration->getDefaultRequestProtocol();
        $protocol = $this->gifProviderProxy->getCredentials()->protocol ?? $defaultProtocol;
        $domain = $this->gifProviderProxy->getResearchDomain();
        $apiKey = $this->gifProviderProxy->getCredentials()->api_key;
        $limit = $this->configuration->getMaxResultsToShow();

        $response = Http::get($protocol.'://'.$domain, $this->generateParams($keyword, $apiKey, $limit));

        if (is_null($response) || !$response->successful())
        {
            return self::ERROR_MESSAGE;
        }

        return $response->body();
    }

    protected abstract function generateParams($keyword, $apiKey, $limit);
}