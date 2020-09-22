<?php

use Illuminate\Support\Facades\Route;

//TODO: This route should point to something different
Route::get('/', function () {
    return view('welcome');
});

Route::get('/providers', 'GifProviderController@list');
Route::get('/provider/{identifiers}/stats', 'GifProviderController@show');
Route::post('/provider/{identifiers}', 'GifProviderController@setDefaultProvider');
Route::get('/gifs/{keyword}', 'SearchController@search');
Route::get('/gifs/{keyword}/stats', 'SearchController@showStatsPerKeyword');
