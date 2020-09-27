<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GifProviderController;
use App\Http\Controllers\ChangeProviderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\KeywordsController;

// TODO: This route should point to something different
Route::get('/', function () {
    return view('welcome');
});

// TODO: these routes should live in api.php
Route::get('/providers', [GifProviderController::class, 'list']);
Route::get('/provider/{identifiers}/stats', [GifProviderController::class, 'showStats']);
Route::post('/provider/{identifier}', [ChangeProviderController::class, 'setDefaultProvider']);
Route::get('/gifs/{keyword}', [SearchController::class, 'search']);
Route::get('/gifs/{keyword}/stats', [KeywordsController::class, 'showStatsPerKeyword']);
