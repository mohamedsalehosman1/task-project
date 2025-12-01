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

    Route::get('vendors/profile', 'Dashboard\VendorsController@profile')->name('vendors.profile');
    Route::put('update-profile/{vendor}', 'Dashboard\VendorsController@updateProfile')->name('vendors.updateProfile');

    Route::get('vendors/requests', 'Dashboard\VendorsController@requests')->name('vendors.requests');
    Route::get('vendors/rejected', 'Dashboard\VendorsController@rejected')->name('vendors.rejected');

    Route::get('vendors/trashed', 'Dashboard\VendorsController@trashed')->name('vendors.trashed');
    Route::get('vendors/restore/{vendor}', 'Dashboard\VendorsController@restore')->name('vendors.restore');
    Route::get('vendors/force-delete/{vendor}', 'Dashboard\VendorsController@forceDelete')->name('vendors.forceDelete');

    // block routes
    Route::patch('vendors/{vendor}/block', 'Dashboard\VendorsController@block')->name('vendors.block');
    Route::patch('vendors/{vendor}/unblock', 'Dashboard\VendorsController@unblock')->name('vendors.unblock');

    // change status the vendor
    Route::post('vendors/{vendor}/status', 'Dashboard\VendorsController@status')->name('vendors.status');

    // edit data
    Route::put('vendors/{vendor}/edit', 'Dashboard\VendorsController@updateData')->name('vendors.update.data');

    Route::resource('vendors', 'Dashboard\VendorsController');
        Route::post('vendors/{vendor}/status', 'Dashboard\VendorsController@status')->name('vendors.changeStatus');

});
