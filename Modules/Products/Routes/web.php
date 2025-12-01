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

use Modules\Products\Http\Controllers\Dashboard\ProductController;

Route::middleware('dashboard')->prefix('dashboard')->as('dashboard.')->group(function () {
    Route::resource('products', 'Dashboard\ProductController');

});
Route::get('products/requests', [ProductController::class, 'requests'])
    ->name('requests');
Route::put('products/{product}/accept', 'Dashboard\ProductController@accept')->name('acceptproduct');
Route::put('/user-products/{userProduct}/accept', 'Dashboard\ProductController@acceptUserProduct')->name('acceptuserproduct');

Route::put('products/{product}/reject', 'Dashboard\ProductController@reject')->name('rejectproduct');
Route::put('/user-products/{userProduct}/reject', 'Dashboard\ProductController@rejectUserProduct')->name('rejectuserproduct');
Route::post('products/active/{product}', [ProductController::class, 'activate']);

