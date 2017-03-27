<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => config('geoUtils.routes.prefix')], function() {
    Route::get('/'. config('geoUtils.routes.geoByIp.uri') .'/{ip?}', ['as' => config('geoUtils.routes.geoByIp.name'), 'uses' => '\Codeheures\LaravelGeoUtils\Http\Controllers\UtilsController@geoByIp']);
    Route::get('/'. config('geoUtils.routes.geoLocByIp.uri') .'/{ip?}', ['as' => config('geoUtils.routes.geoLocByIp.name'), 'uses' => '\Codeheures\LaravelGeoUtils\Http\Controllers\UtilsController@geoLocByIp']);
    Route::get('/'. config('geoUtils.routes.countryByIp.uri') .'/{ip?}', ['as' => config('geoUtils.routes.countryByIp.name'), 'uses' => '\Codeheures\LaravelGeoUtils\Http\Controllers\UtilsController@countryByIp']);
    Route::get('/'. config('geoUtils.routes.refreshDb.uri') , ['as' => config('geoUtils.routes.refreshDb.name'), 'uses' => '\Codeheures\LaravelGeoUtils\Http\Controllers\UtilsController@refreshDb']);
});