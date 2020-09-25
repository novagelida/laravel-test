<?php

namespace App\Http\Controllers;

class KeywordsController extends Controller
{
    public function showStatsPerKeyword($keyword)
    {
        return "you were looking for ".$keyword;
    }
}