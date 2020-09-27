<?php

namespace App\Http\Middleware\Interfaces;

interface IGifProvidersProxy
{
    public function getCallsPerProvider(string $identifier);

    public function getKeywordsPerProvider(string $identifier);

    public function isProviderAvailable(string $identifier) : bool;

    public function getProviderList();

    public function updateCredentials(string $identifier, $credentials);
}