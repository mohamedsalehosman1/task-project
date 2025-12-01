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

// use Modules\Carts\Http\Controllers\Api\CartController;

Route::middleware('auth:sanctum')->group(
    function () {
        Route::delete('carts/remove-all-cart', 'Api\CartController@destroyAllCart')->name('cart.remove-all-cart');
        Route::post('carts/remove-from-cart', 'Api\CartController@destroy')->name('cart.remove-from-cart');
        Route::apiResource('carts', 'Api\CartController')->except(['update', 'show']);
    }
);
