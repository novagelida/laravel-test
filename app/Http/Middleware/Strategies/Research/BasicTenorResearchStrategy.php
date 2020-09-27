<?php

namespace App\Http\Middleware\Strategies\Research;

use App\Http\Middleware\Strategies\Research\AbstractResearchStrategy;

class BasicTenorResearchStrategy extends AbstractResearchStrategy
{
    protected function generateParams($keyword, $apiKey, $limit)
    {
        return ['q'=>$keyword, 'key'=> $apiKey, 'limit'=>$limit];
    }
}