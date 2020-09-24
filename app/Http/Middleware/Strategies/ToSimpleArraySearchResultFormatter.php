<?php

namespace App\Http\Middleware\Strategies;

use App\Http\Middleware\Interfaces\ISearchResultFormatter;

class ToSimpleArraySearchResultFormatter implements ISearchResultFormatter
{
    public function format(array $results) : array
    {
        return [];
    }
}