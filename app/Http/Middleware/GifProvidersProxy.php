<?php

namespace App\Http\Middleware;

use App\Models\GifProvider;
use App\Http\Middleware\Interfaces\IGifProvidersProxy;

class GifProvidersProxy implements IGifProvidersProxy
{
    private const PROVIDER_NOT_FOUND_MESSAGE = "Sorry, we didn't find any provider with the requested identifier";

    public function getCallsPerProvider($identifier)
    {
        return $this->getProviderByIdentifier($identifier)->calls;
    }

    public function getKeywordsPerProvider($identifier)
    {
        return $this->getProviderByIdentifier($identifier)->keyword()->select('keyword_value', 'call_counter')->get();
    }

    public function getProviderList()
    {
        return GifProvider::select('identifier', 'description', 'calls')->get();
    }

    private function getProviderByIdentifier($identifier)
    {
        //TODO: I might use firstOrFail and handle the error in a custom class
        //TODO: I might cache the providerData to prevent unnecessary DB accesses
        $providerData = GifProvider::where('identifier', $identifier)->first();

        if (empty($providerData->identifier))
        {
            abort(404, self::PROVIDER_NOT_FOUND_MESSAGE);
        }

        return $providerData;
    }
}