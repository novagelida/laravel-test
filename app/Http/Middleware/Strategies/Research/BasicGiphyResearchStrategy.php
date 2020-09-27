<?php

namespace App\Http\Middleware\Strategies\Research;

use App\Http\Middleware\Strategies\Research\AbstractResearchStrategy;

class BasicGiphyResearchStrategy extends AbstractResearchStrategy
{
    protected function generateParams($keyword, $apiKey, $limit)
    {
        return ['q'=>$keyword, 'api_key'=> $apiKey, 'limit'=>$limit];
    }
}