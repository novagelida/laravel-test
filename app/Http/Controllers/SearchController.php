<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Interfaces\IConfigurationProvider;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    private $configuration;

    public function __construct(IConfigurationProvider $configurationProvider)
    {
        $this->configuration = $configurationProvider;
    }

    public function search(string $keyword)
    {
        $keyword = $this->sanitize(trim($keyword));

        $gifProvider = $this->configuration->getGifProvider();

        $keywordKey = hash('md5', $keyword);
        if (Cache::has($keywordKey))
        {
            //do something
            return "item in cache";
        }

        //perform research
        Cache::put($keywordKey, $keyword, now()->addHours(6));

        return $keyword;
    }

    private function sanitize(string $keyword) : string
    {
        return implode(" ", array_filter(explode("_", preg_replace('/[^\w-]/', '_', strtolower($keyword))),
            function ($word) {
                return $this->isSearchTermValid($word);
            }));
    }

    private function isSearchTermValid(string $term) : bool
    {
        return !empty($term) && !(strlen($term) < $this->configuration->getSearchTermMinLength());
    }
}
