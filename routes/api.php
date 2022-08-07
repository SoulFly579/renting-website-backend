<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductGalleryController;
use App\Http\Controllers\Api\ProductVariantGroupController;
use App\Http\Controllers\Api\ProductVariantValueController;
use App\Http\Controllers\Api\RentTimeController;
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

    /* Start Address */
    Route::resource("address",AddressController::class);
    /* End Address */

    Route::prefix("/renter")->middleware("role:renter|admin")->group(function (){
        Route::resource("product",ProductController::class)->except(["show"]);
        Route::resource("product.gallery",ProductGalleryController::class)->only(["store","destroy"]);
        Route::resource("product.variant_group",ProductVariantGroupController::class)->except(["show"]);
        Route::resource("product.variant_group.variant_value",ProductVariantValueController::class)->except(["index","show"]);
        Route::resource("rent_time",RentTimeController::class)->except(["show"]);
    });

    Route::prefix("/admin")->middleware("role:admin")->group(function (){
        Route::resource("category",CategoryController::class)->except(["show"]);
    });
});
