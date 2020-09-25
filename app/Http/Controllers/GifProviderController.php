<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Interfaces\IGifProvidersProxy;

class GifProviderController extends Controller
{
    //TODO: those messages can go to the Configuration tables. I don't need to hardcode them.
    private const EMPTY_ARRAY_MESSAGE = "Sorry, we didn't find any available gif providers";
    private $gifProvidersProxy;

    function __construct(IGifProvidersProxy $gifProvidersProxy)
    {
        $this->gifProvidersProxy = $gifProvidersProxy;
    }

    public function showStats(string $identifier)
    {
        $toReturn = ["calls" => $this->gifProvidersProxy->getCallsPerProvider($identifier),
                     "keywords" => $this->gifProvidersProxy->getKeywordsPerProvider($identifier)];

        return $toReturn;
    }

    public function list()
    {
        $providers = ["providers" => $this->gifProvidersProxy->getProviderList()];

        if (empty($providers))
        {
            return self::EMPTY_ARRAY_MESSAGE;
        }

        return $providers;
    }
}
