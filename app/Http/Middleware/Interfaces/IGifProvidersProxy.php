<?php

namespace App\Http\Middleware\Interfaces;

interface IGifProvidersProxy
{
    public function getCallsPerProvider($identifier);

    public function getKeywordsPerProvider($identifier);

    public function getProviderList();
}