<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckAdmin;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {

    Route::get('/facebook', [SocialController::class, 'facebookRedirect']);
    Route::get('/facebook/callback', [SocialController::class, 'loginWithFacebook']);
    Route::get('/google', [SocialController::class, 'redirectToGoogle']);
    Route::get('/google/callback', [SocialController::class, 'handleGoogleCallback']);
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

        Route::prefix('admin')->middleware([CheckAdmin::class])->group(function () {
            Route::post('/changeRole/{id}', [AdminController::class, 'changeRole']);

            Route::prefix('students')->group(function () {
                Route::get('/', [AdminController::class, 'getStudents']);
                Route::delete('/delete/{id}', [AdminController::class, 'deleteStudent']);
            });

            Route::prefix('teachers')->group(function () {
                Route::get('/', [AdminController::class, 'getTeachers']);
                Route::delete('/delete/{id}', [AdminController::class, 'delete']);
            });
        });
    });
    
});

