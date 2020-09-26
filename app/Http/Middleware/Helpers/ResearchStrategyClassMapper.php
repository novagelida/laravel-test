<?php

namespace App\Http\Middleware\Helpers;

use App\Http\Middleware\Strategies\BasicTenorResearchStrategy;
use App\Http\Middleware\Strategies\BasicGiphyResearchStrategy;

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