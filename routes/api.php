<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/backstories/{portion?}', 'BackstoryController@index');
Route::get('/maps/{slug}', 'MapsController@get');
Route::get('labels', 'LabelsController@index');

Route::put('/maps/{slug}', 'MapsController@update');
Route::put('/backstories/{portion}/{id}', 'BackstoryController@update');

Route::post('/maps', 'MapsController@create');
Route::post('/tickets', 'TicketController@create');
Route::post('/backstories/{portion}/', 'BackstoryController@create');

Route::delete('/backstories/{portion}/{id}', 'BackstoryController@delete');
