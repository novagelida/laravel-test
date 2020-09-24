<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Interfaces\IKeywordProxy;
use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Http\Middleware\Interfaces\IGifProviderProxy;
use App\Http\Middleware\Interfaces\ISearchResultFormatter;
use App\Http\Middleware\Interfaces\IResearchStrategy;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    private $configuration;
    private $gifProviderProxy;
    private $keywordProxy;
    private $researchStrategy;

    public function __construct(IConfigurationProvider $configurationProvider,
                                IKeywordProxy $keywordProxy,
                                IGifProviderProxy $gifProviderProxy,
                                ISearchResultFormatter $searchResultFormatter,
                                IResearchStrategy $researchStrategy)
    {
        $this->configuration = $configurationProvider;
        $this->gifProviderProxy = $gifProviderProxy;
        $this->keywordProxy = $keywordProxy;
        $this->searchResultsFormatter = $searchResultFormatter;
        $this->researchStrategy = $researchStrategy;
    }

    public function search(string $keyword)
    {
        $keyword = $this->sanitize($keyword);

        if (empty($keyword))
        {
            return "Error!";
        }

        $this->incrementKeywordCallCounter($keyword);

        if (Cache::has($keyword))
        {
            return Cache::get($keyword);
        }

        $this->gifProviderProxy->incrementCalls($keyword);

        $results = $this->researchStrategy->search($keyword);
        $results = $this->searchResultsFormatter->format($results);

        Cache::put($keyword, $results, now()->addHours(6));

        return $results;
    }

    private function incrementKeywordCallCounter(string $keyword)
    {
        $keywordModel = $this->keywordProxy->getKeyword($keyword);

        if ($keywordModel == null) {
            $this->keywordProxy->insertKeyword($keyword);
        } else {
            $this->keywordProxy->incrementCallCounter($keywordModel);
        }

        $this->keywordProxy->incrementOrCreateRelationshipCalls($this->gifProviderProxy->getDefaultGifProvider(), $keyword);
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
