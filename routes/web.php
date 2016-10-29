<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'PageController@index')->name('homepage');
Route::get('/faq', 'PageController@faq')->name('faq');
Route::get('/stats', 'PageController@stats')->name('stats');
Route::get('/servers', 'PageController@servers')->name('servers');
Route::get('/map', 'PageController@getMap')->name('map.get');
Route::post('/map', 'PageController@postMap')->name('map.post');


Route::group(['prefix' => 'server', 'as' => 'server.'], function () {
    Route::post('/search', 'ServerController@postSearch')->name('postSearch');
    Route::get('/search/{server_ip}', 'ServerController@getSearch')->name('getSearch');
    Route::get('{ip}/information', 'ServerController@information')->name('information');
    Route::get('{ip}/banner/{color1?}/{color2?}', 'ServerController@banner')->name('banner');
});


