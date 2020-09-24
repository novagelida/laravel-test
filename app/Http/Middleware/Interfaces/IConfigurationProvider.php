<?php

namespace App\Http\Middleware\Interfaces;

interface IConfigurationProvider
{
    public function getGifProvider();

    public function getSearchTermMinLength() : int;
}