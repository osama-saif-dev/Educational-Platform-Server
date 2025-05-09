<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StudintsController;
use App\Http\Controllers\Teacher\TracherAuthController;

Route::get('/user', function (Request $request)
{
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function ()
{

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forget_password', [VerifyController::class, 'verifyForgetPassword']);
    Route::post('/reset_password', [VerifyController::class, 'resetPassword']);
    Route::post('/refresh_token', [AuthController::class, 'refreshToken']);

    Route::prefix('/')->middleware('auth:sanctum')->group(function ()
    {
        Route::post('/contact', [UserController::class, 'contact']);
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/send_code', [VerifyController::class, 'sendCode']);
        Route::post('/verify_code', [VerifyController::class, 'checkCode']);
        Route::prefix('admin')->group(function()
        {
            Route::prefix('students')->group(function()
            {
                Route::get('/', [StudintsController::class, 'index'])->name('students.index');
                Route::post('/store', [StudintsController::class, 'store'])->name('students.store');
                Route::post('/update/{id}', [StudintsController::class, 'update'])->name('students.update');
                Route::delete('/delete/{id}', [StudintsController::class, 'delete'])->name('students.delete');

            });

            Route::prefix('teachers')->group(function()
            {
                Route::get('/', [TeacherController::class, 'index'])->name('teachers.index');
                Route::post('/store', [TeacherController::class, 'store'])->name('teachers.store');
                Route::post('/update/{id}', [TeacherController::class, 'update'])->name('teachers.update');
                Route::delete('/delete/{id}', [TeacherController::class, 'delete'])->name('teachers.delete');

            });
        });
    });

});



Route::prefix('Teacher')->group(function()
{
    Route::prefix('auth')->group(function()
    {
        Route::post('/login', [TracherAuthController::class, 'login']);
        Route::post('/register', [TracherAuthController::class, 'register']);
        Route::post('/forget_password', [VerifyController::class, 'verifyForgetPassword']);
        Route::post('/reset_password', [VerifyController::class, 'resetPassword']);
        Route::post('/refresh_token', [TracherAuthController::class, 'refreshToken']);

        Route::prefix('/')->middleware('auth:sanctum')->group(function ()
        {
            Route::get('/logout', [AuthController::class, 'logout']);
        });
    });


    Route::prefix('/')->middleware('auth:sanctum')->group(function ()
    {
        // Route::get('/logout', [AuthController::class, 'logout']);
    });
});





Route::get('/auth/facebook', [SocialController::class, 'facebookRedirect']);
Route::get('/auth/facebook/callback', [SocialController::class, 'loginWithFacebook']);

