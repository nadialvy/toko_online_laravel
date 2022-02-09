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


//LOGIN
Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

Route::group(['middleware' => ['jwt.verify']], function(){
    //post start
    Route::post('/Customers', 'CustomersController@store');
    Route::post('/Officer', 'OfficerController@store');
    Route::post('/Product', 'ProductController@store');
    Route::post('/Order', 'OrderController@store');
    Route::post('/OrderDetail', 'OrderDetailController@store');

    //get start
    Route::get('/Customers', 'CustomersController@show');
    Route::get('/Customers/{id}', 'CustomersController@detail');

    Route::get('/Officer', 'OfficerController@show');
    Route::get('/Officer/{id}', 'OfficerController@detail');

    Route::get('/Product', 'ProductController@show');
    Route::get('/Product/{id}', 'ProductController@detail');

    Route::get('/Order', 'OrderController@show');
    Route::get('/Order/{id}', 'OrderController@detail');

    Route::get('/OrderDetail', 'OrderDetailController@show');
    Route::get('/OrderDetail/{id}', 'OrderDetailController@detail');

    //put start
    Route::put('/Customers/{id}', 'CustomersController@update');

    Route::put('/Officer/{id}', 'OfficerController@update');

    Route::put('/Product/{id}', 'ProductController@update');

    Route::put('/Order/{id}', 'OrderController@update');

    Route::put('/Order/{id}', 'OrderController@update');

    Route::put('/OrderDetail/{id}', 'OrderDetailController@update');

    //delete start
    Route::delete('/Customers/{id}', 'CustomersController@delete');
    Route::delete('/Officer/{id}', 'OfficerController@delete');
    Route::delete('/Product/{id}', 'ProductController@delete');
    Route::delete('/Order/{id}', 'OrderController@delete');
    Route::delete('/OrderDetail/{id}', 'OrderDetailController@delete');


});






