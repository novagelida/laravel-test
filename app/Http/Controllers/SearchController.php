<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Http\Middleware\Interfaces\IKeywordProxy;
use App\Http\Middleware\Interfaces\IGifProviderProxy;
use App\Http\Middleware\Interfaces\ISearchResultFormatter;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    private $configuration;
    private $keywordProxy;
    private $gifProviderProxy;

    public function __construct(IConfigurationProvider $configurationProvider,
                                IKeywordProxy $keywordProxy,
                                IGifProviderProxy $gifProviderProxy,
                                ISearchResultFormatter $searchResultFormatter)
    {
        $this->configuration = $configurationProvider;
        $this->keywordProxy = $keywordProxy;
        $this->gifProviderProxy = $gifProviderProxy;
        $this->searchResultsFormatter = $searchResultFormatter;
    }

    public function search(string $keyword)
    {
        $keyword = $this->sanitize($keyword);
        $this->incrementCallCounter($keyword);

        $gifProvider = $this->configuration->getGifProvider();

        if (Cache::has($keyword))
        {
            return Cache::get($keyword);
        }

        $this->gifProviderProxy->incrementCalls($keyword);

        $results = $this->gifProviderProxy->getResearchStrategy()->search($keyword);
        $this->searchResultsFormatter->format($results);

        Cache::put($keyword, $results, now()->addHours(6));

        return $results;
    }

    private function incrementCallCounter(string $keyword)
    {
        $keywordModel = $this->keywordProxy->getKeyword($keyword);

        if ($keywordModel == null)
        {
            $this->keywordProxy->insertKeyword($keyword);
            return;
        }

        $this->keywordProxy->incrementCallCounter($keywordModel);
    }

    private function sanitize(string $keyword) : string
    {
        //TODO: This logic can go into a configurable strategy set at config time
        return implode(" ", array_filter(explode("_", preg_replace('/[^\w-]/', '_', strtolower(trim($keyword)))),
            function ($word) {
                return $this->isSearchTermValid($word);
            }));
    }

    private function isSearchTermValid(string $term) : bool
    {
        return !empty($term) && !(strlen($term) < $this->configuration->getSearchTermMinLength());
    }
}
