<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GifProviderController;

//TODO: This route should point to something different
Route::get('/', function () {
    return view('welcome');
});

Route::get('/providers', [GifProviderController::class, 'list']);
Route::get('/provider/{identifiers}/stats', 'GifProviderController@show');
Route::post('/provider/{identifiers}', 'GifProviderController@setDefaultProvider');
Route::get('/gifs/{keyword}', 'SearchController@search');
Route::get('/gifs/{keyword}/stats', 'SearchController@showStatsPerKeyword');
