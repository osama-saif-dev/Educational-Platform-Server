<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forget_password', [VerifyController::class, 'verifyForgetPassword']);
    Route::post('/reset_password', [VerifyController::class, 'resetPassword']);
    Route::post('/refresh_token', [AuthController::class, 'refreshToken']);
    
    Route::prefix('/')->middleware('auth:sanctum')->group(function () {
        Route::post('/contact', [UserController::class, 'contact']);
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/send_code', [VerifyController::class, 'sendCode']);
        Route::post('/verify_code', [VerifyController::class, 'checkCode']);
    });

});