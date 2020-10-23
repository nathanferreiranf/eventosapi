<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\EmailsController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/verify-login/{id_user}', [AuthController::class, 'verifyLogin']);

Route::resource('/eventos', EventosController::class);

Route::prefix('emails')->group(function () {
    Route::post('/reset-password/{email}', [EmailsController::class, 'sendResetPassword']);
    Route::put('/reset-password/{id_user}', [EmailsController::class, 'resetPassword']);
    //Route::post('/confirmation', [EmailsController::class, 'sendConfirmation']);

    Route::post('/welcome', [EmailsController::class, 'sendWelcome']);
});
