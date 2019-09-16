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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('apitoken')->namespace('Api')->group(function() {
    Route::post('/login', 'LoginController@login');

    Route::middleware('authtoken')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::middleware('authtoken')->get('/posts', function (Request $request) {
        return $request->user()->posts;
    });
});
