<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Http\Middleware\Interfaces\IKeywordProxy;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    private $configuration;
    private $keywordProxy;

    public function __construct(IConfigurationProvider $configurationProvider,
                                IKeywordProxy $keywordProxy)
    {
        $this->configuration = $configurationProvider;
        $this->keywordProxy = $keywordProxy;
    }

    public function search(string $keyword)
    {
        $keyword = $this->sanitize(trim($keyword));
        $this->incrementCallCounter($keyword);

        $gifProvider = $this->configuration->getGifProvider();

        if (Cache::has($keyword))
        {
            //do something
            return Cache::get($keyword);
        }

        //increment calls for provider
        //increment calls for manytomany relationship
        //perform research
        //Cache::put($keyword, $result, now()->addHours(6));

        return $keyword;
    }

    private function incrementCallCounter(string $keyword)
    {
        if ($this->keywordProxy->getKeyword($keyword) == null)
        {
            $this->keywordProxy->insertKeyword($keyword);
            return;
        }

        $this->keywordProxy->incrementCallCounter($keyword);
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
