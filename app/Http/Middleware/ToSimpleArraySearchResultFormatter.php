<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Interfaces\ISearchResultFormatter;

class ToSimpleArraySearchResultFormatter implements ISearchResultFormatter
{
    public function format(array $results) : array
    {
        return [];
    }
}