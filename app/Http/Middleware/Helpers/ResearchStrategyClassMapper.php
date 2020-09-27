<?php

namespace App\Http\Middleware\Helpers;

use App\Http\Middleware\Strategies\Research\BasicTenorResearchStrategy;
use App\Http\Middleware\Strategies\Research\BasicGiphyResearchStrategy;

class ResearchStrategyClassMapper
{
    private static $classNameMap = null;

    public static function map($key)
    {
        if (self::$classNameMap == null)
        {
            self::initialiseClassNameMap();
        }

        return self::$classNameMap[$key];
    }

    private static function initialiseClassNameMap()
    {
        self::$classNameMap = ['basicTenor' => BasicTenorResearchStrategy::class,
                               'basicGiphy' => BasicGiphyResearchStrategy::class
                            ];
    }
}