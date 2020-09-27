<?php

namespace App\Http\Controllers;

use App\Events\DefaultProviderChanged;
use App\Http\Middleware\Interfaces\IGifProvidersProxy;

class ChangeProviderController extends Controller
{
    private const NON_EXISTING_PROVIDER_ERROR_MESSAGE = "The requested provider does not exist!";

    private $gifProvidersProxy;

    public function __construct(IGifProvidersProxy $gifProvidersProxy)
    {
        $this->gifProvidersProxy = $gifProvidersProxy;
    }

    public function setDefaultProvider(string $identifier)
    {
        if (!$this->gifProvidersProxy->isProviderAvailable($identifier))
        {
            abort(404, self::NON_EXISTING_PROVIDER_ERROR_MESSAGE);
        }

        event(new DefaultProviderChanged($identifier));

        return response("ok", 204);
    }
}