<?php

namespace App\Http\Middleware\Interfaces;

interface IResearchStrategy
{
    public function search(string $keyword) : array;
}