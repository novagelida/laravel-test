<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Interfaces\IKeywordProxy;
use App\Models\Keyword;
use App\Models\GifProviderKeyword;

class KeywordProxy implements IKeywordProxy
{
    public function resetProvidersCallCount(string $keyword)
    {
        $statsPerProvider = $this->getKeyword($keyword)->gifProviders()->get();

        if (empty($statsPerProvider))
        {
            return;
        }

        foreach ($statsPerProvider as &$row)
        {
            $row->pivot->call_counter = 0;
            $row->pivot->save();
        }
    }

    public function getKeyword(string $keyword)
    {
        return Keyword::where('value', $keyword)->first();
    }

    public function getStatsPerKeyword(string $keyword)
    {
        return GifProviderKeyword::where('keyword_value', $keyword)->select('gif_provider_identifier', 'call_counter')->get();
    }

    public function incrementCallCounter($keywordModel)
    {
        $keywordModel->incrementCalls();
    }

    public function insertKeyword(string $keyword)
    {
        $keywordModel = new Keyword;
        $keywordModel->value = $keyword;
        $keywordModel->save();
    }

    public function incrementOrCreateRelationshipCalls($provider, string $keyword)
    {
        $relationship = $provider->keywords()->where('keyword_value', $keyword)->first();

        if ($relationship == null)
        {
            $provider->keywords()->attach($keyword);
            return;
        }

        $this->incrementRelationshipCalls($relationship->pivot);
    }

    private function incrementRelationshipCalls($relationship)
    {
        $relationship->call_counter++;
        $relationship->save();
    }
}