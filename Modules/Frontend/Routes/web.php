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

    Route::get('/', 'FrontendController@index')->name('home');

    Route::get('/about', 'FrontendController@about')->name('about');

    Route::get('/services', 'FrontendController@services')->name('services');

    Route::get('/projects', 'FrontendController@projects')->name('projects');

    Route::get('/projects/{project}', 'FrontendController@project')->name('projects.details');

    Route::get('/contact', 'FrontendController@contactGet')->name('contact');

    Route::post('/contact', 'FrontendController@contactPost')->name('contact.post');
});
