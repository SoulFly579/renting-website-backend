<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductGalleryController;
use App\Http\Controllers\Api\ProductVariantGalleryController;
use App\Http\Controllers\Api\ProductVariantGroupController;
use App\Http\Controllers\Api\ProductVariantValueController;
use App\Http\Controllers\Api\ProductAdditionGroupController;
use App\Http\Controllers\Api\ShoppingSessionController;
use App\Http\Controllers\Api\ProductAdditionOptionController;
use App\Http\Controllers\Api\CartItemController;
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
    Route::resource("address",AddressController::class)->except("create","show");
    /* End Address */

    /* Start Cart */
    Route::prefix("/cart")->group(function(){
        Route::prefix("/product/{product}")->group(function(){
            Route::post("/add",[CartItemController::class,"add"]);
            Route::post("/increase",[CartItemController::class,"increase"]);
            Route::post("/decrease",[CartItemController::class,"decrease"]);
            Route::post("/clear",[CartItemController::class,"clear"]);
        });
        Route::get("/",[ShoppingSessionController::class,"index"]);
        Route::post("/clear_all",[ShoppingSessionController::class,"clear_all"]);

    });
    /* End Cart */

    Route::prefix("/renter")->middleware("role:renter|admin")->group(function (){
        Route::resource("product",ProductController::class)->except(["show"]);
        Route::resource("product.addition_group",ProductAdditionGroupController::class)->only(["store","destroy","update"]);
        Route::resource("product.addition_group.addition_option",ProductAdditionOptionController::class)->except(["show"]);
        Route::resource("product.gallery",ProductGalleryController::class)->only(["store","destroy"]);
        Route::resource("product.variant_group",ProductVariantGroupController::class)->except(["show"]);
        Route::resource("product.variant_group.variant_value",ProductVariantValueController::class)->except(["index","show"]);
        Route::resource("product.variant_group.variant_value.gallery",ProductVariantGalleryController::class)->only(["store","destroy"]);
        Route::resource("rent_time",RentTimeController::class)->except(["show"]);
    });

    Route::prefix("/admin")->middleware("role:admin")->group(function (){
        Route::resource("category",CategoryController::class)->except(["show"]);
    });
});
