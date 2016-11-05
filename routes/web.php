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

/** Utils Routes */
Route::group(['prefix' => 'util', 'as' => 'util.'], function () {
    Route::get('/natives', 'PageController@natives')->name('natives');
    Route::get('/map', 'MapConverterController@getMap')->name('map.get');
    Route::post('/map', 'MapConverterController@postMap')->name('map.post');
    Route::get('/forum-stats', 'PageController@forumStats')->name('forum.stats');
});

Route::group(['prefix' => 'server', 'as' => 'server.'], function () {
    Route::post('/search', 'ServerController@postSearch')->name('postSearch');
    Route::get('/search/{server_ip}', 'ServerController@getSearch')->name('getSearch');
    Route::get('{ip}/information', 'ServerController@information')->name('information');
    Route::get('{ip}/banner/{color1?}/{color2?}', 'ServerController@banner')->name('banner');
});


