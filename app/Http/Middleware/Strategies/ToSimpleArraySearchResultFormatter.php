<?php

namespace App\Http\Middleware\Strategies;

use App\Http\Middleware\Interfaces\ISearchResultFormatter;

class TenorResultToSimpleArrayFormatter implements ISearchResultFormatter
{
    public function format($results)
    {
        return $results;
    }
}