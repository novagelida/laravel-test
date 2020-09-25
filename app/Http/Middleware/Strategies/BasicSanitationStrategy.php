<?php

namespace App\Http\Middleware\Strategies;

use App\Http\Middleware\Interfaces\ISanitationStrategy;
use App\Http\Middleware\Interfaces\IConfigurationProvider;

class BasicSanitationStrategy implements ISanitationStrategy
{
    private $configuration;

    public function __construct(IConfigurationProvider $configurationProvider)
    {
        $this->configuration = $configurationProvider;
    }

    public function sanitize(string $keyword) : string
    {
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