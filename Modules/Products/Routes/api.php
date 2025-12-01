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


Route::middleware('auth:sanctum')->apiResource('products', 'Api\ProductController')->only('index', 'show','store');
Route::post('select/get-products-by-vendor/{id}', 'Api\SelectController@vendorProducts');
Route::get('userproducts/{id}', 'Api\ProductController@showuserproduct');
