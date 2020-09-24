<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Interfaces\IKeywordProxy;
use App\Models\Keyword;

class KeywordProxy implements IKeywordProxy
{
    public function getKeyword(string $keyword)
    {
        return Keyword::where('value', $keyword)->first();
    }

    public function incrementCallCounter($keywordModel)
    {
        $keywordModel->calls = $keywordModel->calls+1;
        $keywordModel->save();
    }

    public function insertKeyword(string $keyword)
    {
        $keywordModel = new Keyword;
        $keywordModel->value = $keyword;
        $keywordModel->save();
    }
}