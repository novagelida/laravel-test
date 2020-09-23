<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\ConfigurationProvider;

class SearchController extends Controller
{
    private $configurationProvider;

    public function __construct(ConfigurationProvider $configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
    }

    public function search(string $keyword)
    {
        //TODO: trim does not remove spaces in the middle of the word
        $searchTerms = $this->sanitize(trim($keyword));

        return $this->configurationProvider->getTest();
    }

    private function sanitize(string $keyword) : array
    {
        //TODO: I also need to filter away words that are smaller than 3 characters
        return array_filter(explode("_", preg_replace('/[^\w-]/', '_', $keyword)));
    }
}
