<?php

use App\Http\Controllers\AuthController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(Authenticate::class)
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('/login', 'login')->withoutMiddleware(Authenticate::class);
        Route::post('/logout', 'logout');
});
