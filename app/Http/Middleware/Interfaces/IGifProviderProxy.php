<?php

namespace App\Http\Middleware\Interfaces;

interface IGifProviderProxy
{
    public function getDefaultGifProvider();

    public function incrementCalls();

    public function getCredentials();

    public function getResearchDomain() : string;

    public function getKeywords();

    public function getCalls();
}