<?php

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

Route::post('register', 'Auth\RegisterController@register');

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function() {

    // Customer
    Route::post('customer', 'CustomerController@store');

    // Transaction
    Route::get('transaction/{customer}/{transaction_id}', 'TransactionController@show');
    Route::get('transactions/{customer}', 'TransactionController@filter');
    Route::post('transaction', 'TransactionController@store');
    Route::put('transaction/{transaction}', 'TransactionController@update');
    Route::delete('transaction/{transaction_id}', 'TransactionController@delete');
});