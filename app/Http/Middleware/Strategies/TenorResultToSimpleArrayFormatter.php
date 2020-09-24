<?php

namespace App\Http\Middleware\Strategies;

use App\Http\Middleware\Interfaces\ISearchResultFormatter;

class TenorResultToSimpleArrayFormatter implements ISearchResultFormatter
{
    public function format($results)
    {
        return array_map(function ($item) {
                return $this->extractGifUrl($item);
            }, json_decode($results)->results);
    }

    private function extractGifUrl($item)
    {
        return $item->media[0]->gif->url;
    }
}