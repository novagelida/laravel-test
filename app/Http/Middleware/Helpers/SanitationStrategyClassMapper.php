<?php

namespace App\Http\Middleware\Helpers;

use App\Http\Middleware\Strategies\BasicSanitationStrategy;

class SanitationStrategyClassMapper
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
        self::$classNameMap = ['basic' => BasicSanitationStrategy::class];
    }
}