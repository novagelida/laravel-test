<?php

namespace App\Http\Middleware\Strategies;

use App\Http\Middleware\Interfaces\IResearchStrategy;
use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Http\Middleware\Interfaces\IGifProviderProxy;
use Illuminate\Support\Facades\Http;

class BasicTenorResearchStrategy implements IResearchStrategy
{
    private const ERROR_MESSAGE = "Something went wrong in performing your research";

    private $configuration;
    private $gifProviderProxy;

    public function __construct(IConfigurationProvider $configurationProvider,
                                IGifProviderProxy $gifProviderProxy)
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

        $response = Http::get($protocol.'://'.$domain, ['q'=>$keyword, 'key'=> $apiKey, 'limit'=>$limit]);

        if (!$response->successful())
        {
            return self::ERROR_MESSAGE;
        }

        return $response->body();
    }
}