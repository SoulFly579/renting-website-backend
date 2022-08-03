<?php

use App\Http\Controllers\Api\Auth\AuthController;
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

Route::post('/login',[AuthController::class,"login"]);
Route::post('/register',[AuthController::class,"register"]);

Route::middleware("auth:sanctum")->group(function(){
    /* Start Email Verification */
    Route::prefix("/email")->group(function (){
        Route::post('/verify/resend', [AuthController::class,"verify_resend"])->middleware( 'throttle:6,1')->name('verification.send');
    });
    /* End Email Verification */

    Route::view("/profile","auth.profile");

    Route::prefix("/renter")->middleware("role:renter")->group(function (){
        Route::view("/","renter.dashboard");
    });
});
