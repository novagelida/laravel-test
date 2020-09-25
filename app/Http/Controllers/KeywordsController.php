<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Interfaces\IKeywordProxy;

class KeywordsController extends Controller
{
    private $keywordProxy;

    public function __construct(IKeywordProxy $keywordProxy)
    {
        $this->keywordProxy = $keywordProxy;
    }

    public function showStatsPerKeyword($keyword)
    {
        $response = ["stats" => []];

        foreach ($this->keywordProxy->getStatsPerKeyword($keyword) as &$item)
        {
            $response["stats"][$item->gif_provider_identifier] = $item->call_counter;
        }

        return $response;
    }
}