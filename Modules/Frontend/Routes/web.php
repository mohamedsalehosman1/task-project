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

Route::get('locale/{locale}', 'LocaleController@update')->name('frontend.locale');

Route::middleware(['frontend.locales'])->group(function () {

    Route::get('/', 'FrontendController@index')->name('frontend.home');

    Route::get('/about', 'FrontendController@about')->name('frontend.about');

    Route::get('/shop', 'FrontendController@shop')->name('frontend.shop');

    Route::get('/shop/{id}', 'FrontendController@shopSingle')->name('frontend.shop-single');

    Route::get('/services', 'FrontendController@services')->name('frontend.services');

    Route::get('/projects', 'FrontendController@projects')->name('frontend.projects');

    Route::get('/projects/{project}', 'FrontendController@project')->name('frontend.projects.details');

    Route::get('/contact', 'FrontendController@contactGet')->name('frontend.contact');

    Route::post('/contact', 'FrontendController@contactPost')->name('frontend.contact.post');
});
