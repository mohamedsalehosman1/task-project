<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\DashboardController;

Auth::routes();

Route::impersonate();

Route::group([
    'middleware' => ['web', 'auth'], // أو فقط 'web' لو ما تبي حماية
    'prefix' => 'dashboard',
    'as' => 'dashboard.',
], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
});
Route::post('store/register', [RegisterController::class, 'save'])->name("store.register");
