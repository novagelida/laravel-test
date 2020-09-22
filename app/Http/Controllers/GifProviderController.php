<?php

namespace App\Http\Controllers;

use App\Models\GifProvider;
use Illuminate\Http\Request;

class GifProviderController extends Controller
{
    private const EMPTY_ARRAY_MESSAGE = "Sorry, we didn't find any available gif providers";

    public function show($identifier)
    {
        return GifProvider::where('identifier', $identifier)->get();
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
