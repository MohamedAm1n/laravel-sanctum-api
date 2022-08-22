<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Public Routes
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'authenticate']);

Route::get('/products',[ProductController::class,'index']);
Route::get('/products/search/{name}',[ProductController::class,'search']);
Route::get('/products/{product}',[ProductController::class,'show']);

// protected Routes
Route::group(['middleware'=>['auth:sanctum']],function(){
        Route::post('/products',[ProductController::class,'store']);
        Route::post('/products',[ProductController::class,'store']);
        Route::post('/products/{product}',[ProductController::class,'destroy']);
    Route::post('/logout', [AuthController::class , 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
   
