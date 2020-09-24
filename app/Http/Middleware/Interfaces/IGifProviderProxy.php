<?php

namespace App\Http\Middleware\Interfaces;

interface IGifProviderProxy
{
    public function incrementCalls(string $keyword);

    public function getResearchStrategy();
}