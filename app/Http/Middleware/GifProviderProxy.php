<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Interfaces\IGifProviderProxy;
use App\Http\Middleware\Interfaces\IConfigurationProvider;
use App\Http\Middleware\Interfaces\IResearchStrategy;
use App\Models\GifProviderKeyword;

class GifProviderProxy implements IGifProviderProxy
{
    private $configuration;
    private $researchStrategy;

    public function __construct(IConfigurationProvider $configurationProvider,
                                IResearchStrategy $researchStrategy)
    {
        $this->configuration = $configurationProvider;
        $this->researchStrategy = $researchStrategy;
    }

    public function incrementCalls(string $keyword)
    {
        $provider = $this->configuration->getGifProvider();

        $this->incrementProviderCalls($provider);
        $this->incrementCallsOrCreateRelationship($provider, $keyword);
    }

    public function getResearchStrategy()
    {
        return $this->researchStrategy;
    }

    private function incrementProviderCalls($provider)
    {
        $provider->calls = $provider->calls+1;
        $provider->save();
    }
    
    private function incrementCallsOrCreateRelationship($provider, $keyword)
    {
        $relationship = $provider->keyword()->where('keyword_value', $keyword)->first();
    
        if ($relationship == null)
        {
            $this->insertKeywordIntoRelationship($keyword, $provider->identifier);
            return;
        }

        $this->incrementRelationshipCalls($relationship);
    }
    
    private function incrementRelationshipCalls($relationship)
    {
        $relationship->calls = $relationship->calls+1<
        $relationship->save();
    }

    private function insertKeywordIntoRelationship($keyword, $identifier)
    {
        $relationship = new GifProviderKeyword;
        $relationship->keyword_value = $keyword;
        $relationship->gif_provider_identifier = $identifier;
        $relationship->save();
    }
}