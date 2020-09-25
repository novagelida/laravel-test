<?php

namespace App\Http\Controllers;

class ChangeProviderController extends Controller
{
    public function setDefaultProvider(string $identifier)
    {
        return $identifier;
    }
}