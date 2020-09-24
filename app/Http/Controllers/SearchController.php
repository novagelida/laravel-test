<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Http\Middleware\Interfaces\IKeywordProxy;
use App\Http\Middleware\Interfaces\IGifProviderProxy;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    private $configuration;
    private $keywordProxy;
    private $gifProviderProxy;

    public function __construct(IConfigurationProvider $configurationProvider,
                                IKeywordProxy $keywordProxy,
                                IGifProviderProxy $gifProviderProxy)
    {
        $this->configuration = $configurationProvider;
        $this->keywordProxy = $keywordProxy;
        $this->gifProviderProxy = $gifProviderProxy;
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

        $this->gifProviderProxy->incrementCalls($keyword);

        //perform research
        //Cache::put($keyword, $result, now()->addHours(6));

        return $keyword;
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
