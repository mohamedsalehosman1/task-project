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

Route::middleware('dashboard')->prefix('dashboard')->as('dashboard.')->group(function () {
    Route::resource('order-stores', 'Dashboard\OrderController');
    Route::post('order-stores/{order_store}/status', 'Dashboard\OrderController@storeStatus')->name('order-stores.status');

    Route::resource('orders', 'Dashboard\OrderController');
    Route::post('orders/{order}/status', 'Dashboard\OrderController@status')->name('orders.status');
    Route::get('orders/{order}/invoice', 'Dashboard\OrderController@invoice')->name('orders.invoice');
    Route::get('orders/{order}/printReceipt', 'Dashboard\OrderController@printReceipt')->name('orders.printReceipt');
});

Route::get('orders/approval', 'Api\OrderController@approval')->name("approval");
Route::get('orders/cancelled', 'Api\OrderController@cancelled')->name("cancelled");
Route::get('orders/accepted-form', 'Dashboard\OrderController@payForm')->name("pay.accept.form");
Route::get('orders/cancelled-form', 'Dashboard\OrderController@payForm')->name("pay.form");
