<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'bans'], function () {
    Route::get('/datatable', 'API\BanController@datatable')->name('api.bans.datatable');
    Route::get('/', 'API\BanController@index')->name('api.bans');
    Route::get('{social_club}', 'API\BanController@show')->name('api.bans.show');
});
Route::get('/natives', 'API\ServerController@listNatives')->name('api.natives');
Route::get('/servers/internet', 'API\ServerController@listInternetServers')->name('api.servers.internet');
Route::get('/servers/verified', 'API\ServerController@listVerifiedServers')->name('api.servers.verified');
