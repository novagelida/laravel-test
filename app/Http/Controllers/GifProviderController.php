<?php

namespace App\Http\Controllers;

use App\Models\GifProvider;
use Illuminate\Http\Request;

class GifProviderController extends Controller
{
    private const EMPTY_ARRAY_MESSAGE = "Sorry, we didn't find any available gif providers";
    private const PROVIDER_NOT_FOUND_MESSAGE = "Sorry, we didn't find any provider with the requested identifier";

    public function show($identifier)
    {
        $providerData = GifProvider::where('identifier', $identifier)->first();

        if (empty($providerData->identifier))
        {
            abort(404, self::PROVIDER_NOT_FOUND_MESSAGE);
        }

        $toReturn = ["calls" => $providerData->calls];

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
