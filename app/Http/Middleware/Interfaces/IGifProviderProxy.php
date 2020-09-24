<?php

namespace App\Http\Middleware\Interfaces;

interface IGifProviderProxy
{
    public function getDefaultGifProvider();

    public function incrementCalls(string $keyword);

    public function getCredentials();

    public function getResearchDomain() : string;
}