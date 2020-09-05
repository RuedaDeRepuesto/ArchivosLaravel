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

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::group([
    'prefix' => 'files',
], function () {
    Route::post('', 'FileController@Store');
    Route::get('', 'FileController@Index');
    Route::get('/{id}', 'FileController@Get');  
    Route::delete('/{id}', 'FileController@Delete');
    Route::get('/{id}/file', 'FileController@File');
    Route::get('/{id}/preview', 'FileController@Preview');
    
});

Route::group([
    'prefix' => 'types',
], function () {
    Route::get('', 'FileController@Types');    
});