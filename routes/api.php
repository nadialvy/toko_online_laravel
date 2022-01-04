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

Route::post('/Customers', 'CustomersController@store');
Route::post('/Officer', 'OfficerController@store');
Route::post('/Product', 'ProductController@store');
Route::post('/Order', 'OrderController@store');
Route::post('/OrderDetail', 'OrderDetailController@store');