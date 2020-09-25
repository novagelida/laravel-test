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
        return $this->keywordProxy->getStatsPerKeyword($keyword);
    }
}