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


Route::apiResource('services', 'Api\ServicesController')->only(['index', 'show']);

Route::middleware('auth:sanctum')->apiResource('invitations', 'Api\InvitationsController');
