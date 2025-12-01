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

// Select vendors
Route::get('/select/vendors', 'Api\SelectController@vendors')->name('vendors.select');
Route::post('/select/vendors-by-size-id/{id}', 'SelectController@getVendorsBySizeId')->name('vendors.select.by-size');


Route::post('/vendor/login', 'Api\LoginController@login');

Route::post('/vendor/password/forget', 'Api\ResetPasswordController@forget');
Route::post('/vendor/password/code', 'Api\ResetPasswordController@code');
Route::post('/vendor/password/reset', 'Api\ResetPasswordController@reset');

Route::post('/vendor/verification/send', 'Api\VerificationController@send');
Route::post('/vendor/verification/resend', 'Api\VerificationController@send');
Route::post('/vendor/verification/verify', 'Api\VerificationController@verify');

Route::apiResource('vendors', 'SelectController')->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(
    function () {

        Route::get('/vendor/profile', 'Api\ProfileController@show');
        Route::post('/vendor/profile', 'Api\ProfileController@update');

        // change location
        Route::post('/vendor/location', 'Api\ProfileController@location');

        Route::post('/vendor/update/phone', 'Api\ProfileController@updatePhone');
        Route::post('/vendor/verify/phone', 'Api\ProfileController@verifyPhone');

        Route::get('/vendor/user/exist', 'Api\ProfileController@exist');
        Route::post('/vendor/user/preferred-locale', 'Api\ProfileController@preferredLocale');

        Route::post('/vendor/logout', 'Api\ProfileController@logout');

        Route::get('/vendor/user/check', 'Api\ProfileController@check');

        Route::post('/vendor/user/delete', 'Api\ProfileController@delete');
    }
);
