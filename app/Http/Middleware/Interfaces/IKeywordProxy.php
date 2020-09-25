<?php

namespace App\Http\Middleware\Interfaces;

interface IKeywordProxy
{
    public function incrementCallCounter($keywordModel);

    public function insertKeyword(string $keyword);

    public function getKeyword(string $keyword);

    public function incrementOrCreateRelationshipCalls($keywordModel, string $keyword);

    public function getStatsPerKeyword(string $keyword);
}