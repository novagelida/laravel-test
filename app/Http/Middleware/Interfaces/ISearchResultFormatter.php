<?php

namespace App\Http\Middleware\Interfaces;

interface ISearchResultFormatter
{
    public function format($results);
}