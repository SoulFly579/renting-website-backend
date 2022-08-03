<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

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

    /* Start Address */
    Route::resource("address",AddressController::class);
    /* End Address */

    Route::prefix("/renter")->middleware("role:renter")->group(function (){
        Route::resource("product",ProductController::class);
    });

    Route::prefix("/admin")->middleware("role:admin")->group(function (){
        Route::resource("category",CategoryController::class);
    });
});
