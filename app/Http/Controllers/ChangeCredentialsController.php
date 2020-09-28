<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Interfaces\IGifProvidersProxy;
use Illuminate\Http\Request;

class ChangeCredentialsController extends Controller
{
    private const INVALID_IDENTIFIER = "Invalid identifier provided";
    private const PROVIDER_NOT_AVAILABLE = "Provider not available";
    private const CREDENTIALS_UPDATED = "Credentials correctly updated";
    private const INVALID_CREDENTIALS = "The payload does not contain a valid credential json";
    private const IM_A_TEAPOT_ERROR_CODE = 418;

    private $gifProvidersProxy;

    public function __construct(IGifProvidersProxy $gifProvidersProxy)
    {
        $this->gifProvidersProxy = $gifProvidersProxy;
    }

    public function updateCredentials($identifier, Request $request)
    {
        if (strlen($identifier) == 0)
        {
            abort(404, self::INVALID_IDENTIFIER);
        }

        if (!$this->gifProvidersProxy->isProviderAvailable($identifier))
        {
            abort(404, self::PROVIDER_NOT_AVAILABLE);
        }

        if (!$this->validatePayload($request->all()))
        {
            return response(self::INVALID_CREDENTIALS, self::IM_A_TEAPOT_ERROR_CODE);
        }

        $this->gifProvidersProxy->updateCredentials($identifier, json_encode($request->all()));
        
        return response(self::CREDENTIALS_UPDATED, 204);
    }

    private function validatePayload($payload) : bool
    {
        return array_key_exists("api_key", $payload) && array_key_exists("protocol", $payload);
    }
}
