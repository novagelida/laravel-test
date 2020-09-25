<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Interfaces\IKeywordProxy;
use App\Http\Middleware\Interfaces\IGifProviderProxy;
use App\Http\Middleware\Interfaces\ISearchResultFormatter;
use App\Http\Middleware\Interfaces\IResearchStrategy;
use App\Http\Middleware\Interfaces\ISanitationStrategy;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    // TODO: This error message should suggest what the valid keywords are. 
    // TODO: error messages should go into a value object or db
    private const INVALID_KEYWORD_MESSAGE = "Keyword not valid!";
    private const NO_RESULTS_MESSAGE = "No results have been found!";
    private const IM_A_TEAPOT_ERROR_CODE = 418;

    private $gifProviderProxy;
    private $keywordProxy;
    private $researchStrategy;
    private $sanitationStrategy;

    public function __construct(IKeywordProxy $keywordProxy,
                                IGifProviderProxy $gifProviderProxy,
                                ISearchResultFormatter $searchResultFormatter,
                                IResearchStrategy $researchStrategy,
                                ISanitationStrategy $sanitationStrategy)
    {
        $this->gifProviderProxy = $gifProviderProxy;
        $this->keywordProxy = $keywordProxy;
        $this->searchResultsFormatter = $searchResultFormatter;
        $this->researchStrategy = $researchStrategy;
        $this->sanitationStrategy = $sanitationStrategy;
    }

    public function search(string $keyword)
    {
        $keyword = $this->sanitationStrategy->sanitize($keyword);

        if (empty($keyword))
        {
            return self::INVALID_KEYWORD_MESSAGE;
        }

        $this->incrementKeywordCallCounter($keyword);

        if (Cache::has($keyword))
        {
            return Cache::get($keyword);
        }

        $this->gifProviderProxy->incrementCalls();

        $results = $this->researchStrategy->search($keyword);
        $results = $this->searchResultsFormatter->format($results);

        if (empty($results))
        {
            return response(self::NO_RESULTS_MESSAGE, self::IM_A_TEAPOT_ERROR_CODE);
        }

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
}
