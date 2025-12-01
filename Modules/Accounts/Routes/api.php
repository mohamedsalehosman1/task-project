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

Route::post('/register', 'Api\RegisterController@register')->name('user.register');
Route::post('/login', 'Api\LoginController@login')->name('user.login');
Route::post('/update-fcm/{user}', 'SelectController@updateFcm')->name('admin.fcm');

Route::get('unauthenticated', 'Api\LoginController@unauthenticated')->name('unauthenticated');

Route::post('/password/forget', 'Api\ResetPasswordController@forget')->name('user.password.forget');
Route::post('/password/code', 'Api\ResetPasswordController@code')->name('user.password.code');
Route::post('/password/reset', 'Api\ResetPasswordController@reset')->name('user.password.reset');
Route::get('/select/users', 'SelectController@index')->name('users.select');

Route::post('verification/send', 'Api\VerificationController@send')->name('verification.send');
Route::post('verification/resend', 'Api\VerificationController@send')->name('verification.resend');
Route::post('verification/verify', 'Api\VerificationController@verify')->name('verification.verify');


// washers apis

Route::middleware('auth:sanctum')->group(
    function () {

        Route::get('profile', 'Api\ProfileController@show')->name('user.profile.show');
        Route::post('profile', 'Api\ProfileController@update')->name('user.profile.update');

        Route::post('phone/update', 'Api\ProfileController@updatePhone')->name('user.phone.update');
        Route::post('phone/verify', 'Api\ProfileController@verifyPhone')->name('user.phone.verify');

        Route::get('user/exist', 'Api\ProfileController@exist')->name('user.exist');
        Route::post('user/preferred-locale', 'Api\ProfileController@preferredLocale')->name('user.preferred.locale');
        Route::post('fcm', 'Api\ProfileController@updateFcm');

        Route::post('logout', 'Api\ProfileController@logout')->name('user.logout');

        Route::get('user/check', 'Api\ProfileController@check')->name('user.check');

        Route::post('user/delete', 'Api\ProfileController@delete')->name('user.delete');

        Route::apiResource('/user/addresses', 'Api\AddressesController');

        Route::apiResource('/rates', 'Api\RateController')->only('index', 'store');
        Route::post('profile/location', 'Api\ProfileController@updateLocation')->name('user.profile.updateLocation');
        Route::delete('rates/{id}', 'Api\RateController@destroy');
    }

);
