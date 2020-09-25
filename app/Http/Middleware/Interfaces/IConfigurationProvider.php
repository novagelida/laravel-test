<?php

namespace App\Http\Middleware\Interfaces;

interface IConfigurationProvider
{
    public function getGifProvider();

    public function getSearchTermMinLength() : int;

    public function getDefaultRequestProtocol() : string;

    public function getMaxResultsToShow() : int;

    public function getSanitationStrategy() : string;
}