<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

use Modules\Dashboard\Http\Controllers\MediaController;

Route::delete('uploader/media/{media}', [MediaController::class, 'destroy'])
    ->name('uploader.media.destroy');

// Route::post('/test', [\App\Http\Controllers\TestController::class, 'test']);
