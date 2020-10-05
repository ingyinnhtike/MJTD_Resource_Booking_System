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

Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');

Route::get('/details', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/redirect_dashboard', function (Request $request) {
    return view('/admin');
})->middleware('auth:api');
