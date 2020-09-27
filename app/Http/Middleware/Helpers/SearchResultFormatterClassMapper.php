<?php

namespace App\Http\Middleware\Helpers;

use App\Http\Middleware\Strategies\TenorResultToSimpleArrayFormatter;
use App\Http\Middleware\Strategies\GiphyResultToSimpleArrayFormatter;

class SearchResultFormatterClassMapper
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
        self::$classNameMap = ['fromTenorToArray' => TenorResultToSimpleArrayFormatter::class,
                               'fromGiphyToArray' => GiphyResultToSimpleArrayFormatter::class
                            ];
    }
}