<?php

namespace App\Http\Middleware\Strategies;

use App\Http\Middleware\Interfaces\ISearchResultFormatter;

class GiphyResultToSimpleArrayFormatter implements ISearchResultFormatter
{
    public function format($results)
    {
        return array_map(function ($item) {
                return $this->extractGifUrl($item);
            }, json_decode($results)->data);
    }

    private function extractGifUrl($item)
    {
        return $item->url;
    }
}