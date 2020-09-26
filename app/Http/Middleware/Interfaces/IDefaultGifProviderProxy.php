<?php

namespace App\Http\Middleware\Interfaces;

interface IDefaultGifProviderProxy
{
    public function getDefaultGifProvider();

    public function incrementCalls();

    public function getCredentials();

    public function getResearchDomain() : string;

    public function getCalls();
}