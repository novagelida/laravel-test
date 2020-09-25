<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Interfaces\IKeywordProxy;

class KeywordsController extends Controller
{
    private const KEYWORD_NOT_FOUND_MESSAGE = "Keyword not found!";

    private $keywordProxy;

    public function __construct(IKeywordProxy $keywordProxy)
    {
        $this->keywordProxy = $keywordProxy;
    }

    public function showStatsPerKeyword($keyword)
    {
        $stats = $this->keywordProxy->getStatsPerKeyword($keyword);

        if (count($stats) == 0)
        {
            abort(404, self::KEYWORD_NOT_FOUND_MESSAGE);
        }

        return $this->createResponse($stats);
    }

    private function createResponse($stats)
    {
        $response = ["stats" => []];

        foreach ($stats as &$item)
        {
            $response["stats"][$item->gif_provider_identifier] = $item->call_counter;
        }

        return $response;
    }
}