<?php

namespace App\Http\Middleware\Interfaces;

interface IConfigurationProxy
{
    public function setMaxResultsToShow(int $max);
}