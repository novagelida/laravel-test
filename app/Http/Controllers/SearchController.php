<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Interfaces\IConfigurationProvider;

class SearchController extends Controller
{
    private $configuration;

    public function __construct(IConfigurationProvider $configurationProvider)
    {
        $this->configuration = $configurationProvider;
    }

    public function search(string $keyword)
    {
        $searchTerms = $this->sanitize(trim($keyword));

        $gifProvider = $this->configuration->getGifProvider();

        return $searchTerms;
    }

    private function sanitize(string $keyword) : array
    {
        //TODO: I also need to filter away words that are smaller than 3 characters
        return array_filter(
            explode("_", preg_replace('/[^\w-]/', '_', $keyword)),
            function ($word) {
                return $this->isSearchTermValid($word);
            });
    }

    private function isSearchTermValid($term) : bool
    {
        return !empty($term)
                && !(strlen($term) < $this->configuration->getSearchTermMinLength());
    }
}
