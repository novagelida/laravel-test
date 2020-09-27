<?php

namespace App\Http\Middleware;

use App\Models\Configuration;

use App\Http\Middleware\Interfaces\IConfigurationProxy;

class ConfigurationProxy implements IConfigurationProxy
{
    private $defaultConfiguration;

    public function __construct()
    {
        $this->defaultConfiguration = $this->retrieveDefaultConfiguration();
    }

    public function setMaxResultsToShow(int $max)
    {
        $this->defaultConfiguration->setMaxResultsToShow($max);
    }

    private function retrieveDefaultConfiguration()
    {
        return Configuration::where('default', true)->firstOrFail();
    }
}