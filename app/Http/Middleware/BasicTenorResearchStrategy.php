<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Interfaces\IResearchStrategy;

class BasicTenorResearchStrategy implements IResearchStrategy
{
    public function search(string $keyword) : array
    {
        return [];
    }
}