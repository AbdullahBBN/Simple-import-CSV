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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::delete("/removeAll",[\App\Http\Controllers\ProductController::class, "removeAll"]);

Route::get("/getSingleProduct",[\App\Http\Controllers\ProductController::class, "getSingleProduct"]);

Route::get("/getAllProduct",[\App\Http\Controllers\ProductController::class, "getAllProduct"]);
