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
Route::group(['middleware' => 'web', 'prefix' => config('codeheuresUtils.geoIp.routes.prefix')], function() {
    Route::get('/'. config('codeheuresUtils.geoIp.routes.geoByIp.uri') .'/{ip?}', ['as' => config('codeheuresUtils.geoIp.routes.geoByIp.name'), 'uses' => '\Codeheures\LaravelUtils\Http\Controllers\UtilsController@geoByIp']);
    Route::get('/'. config('codeheuresUtils.geoIp.routes.geoLocByIp.uri') .'/{ip?}', ['as' => config('codeheuresUtils.geoIp.routes.geoLocByIp.name'), 'uses' => '\Codeheures\LaravelUtils\Http\Controllers\UtilsController@geoLocByIp']);
    Route::get('/'. config('codeheuresUtils.geoIp.routes.countryByIp.uri') .'/{ip?}', ['as' => config('codeheuresUtils.geoIp.routes.countryByIp.name'), 'uses' => '\Codeheures\LaravelUtils\Http\Controllers\UtilsController@countryByIp']);
    Route::get('/'. config('codeheuresUtils.geoIp.routes.refreshDb.uri') , ['as' => config('codeheuresUtils.geoIp.routes.refreshDb.name'), 'uses' => '\Codeheures\LaravelUtils\Http\Controllers\UtilsController@refreshDb']);
});