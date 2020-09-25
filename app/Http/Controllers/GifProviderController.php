<?php

namespace App\Http\Controllers;

use App\Models\GifProvider;

class GifProviderController extends Controller
{
    //TODO: those messages can go to the Configuration tables. I don't need to hardcode them.
    private const EMPTY_ARRAY_MESSAGE = "Sorry, we didn't find any available gif providers";
    private const PROVIDER_NOT_FOUND_MESSAGE = "Sorry, we didn't find any provider with the requested identifier";

    public function showStats(string $identifier)
    {
        // TODO: refactor this logic to inject the proxy
        $providerData = GifProvider::where('identifier', $identifier)->first();

        if (empty($providerData->identifier))
        {
            abort(404, self::PROVIDER_NOT_FOUND_MESSAGE);
        }

        $toReturn = ["calls" => $providerData->calls, 
                     "keywords" => $providerData->keyword()->select('keyword_value', 'call_counter')->get()];

        return $toReturn;
    }

    public function list()
    {
        $providers = ["providers" => GifProvider::select('identifier', 'description', 'calls')->get()];

        if (empty($providers))
        {
            return self::EMPTY_ARRAY_MESSAGE;
        }

        return $providers;
    }
}
