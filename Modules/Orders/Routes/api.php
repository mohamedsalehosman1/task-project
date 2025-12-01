<?php

use Modules\Payments\Http\Controllers\Api\PaymentController;

Route::middleware('auth:sanctum')->group(
    function () {
        Route::apiResource('orders', 'Api\OrderController')->except('destroy');
        Route::post('orders/orders-cancel/{order}', 'Api\OrderController@cancel');

        Route::middleware('isWorker')->group(
            function () {
                Route::post('orders/orders-accept/{order}', 'Api\OrderController@accept');
                Route::post('orders/orders-inProgress/{order}', 'Api\OrderController@inProgress');
                Route::post('orders/orders-complete/{order}', 'Api\OrderController@complete');
            }
        );


    }
);

Route::get('authorized/url',   [PaymentController::class,'callback'])->name('authorized.url');
Route::get('declined/url',  [PaymentController::class,'declined'])->name('declined.url');

