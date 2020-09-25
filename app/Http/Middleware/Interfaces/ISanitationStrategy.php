<?php

namespace App\Http\Middleware\Interfaces;

interface ISanitationStrategy
{
    public function sanitize(string $keyword) : string;
}