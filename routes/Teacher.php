<?php
use App\Http\Middleware\IsTeacher;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\Teacher\CoursesController;
use App\Http\Controllers\Teacher\discountsController;

Route::middleware('auth:sanctum')->group(function ()
{

    Route::prefix('teachers')->middleware([IsTeacher::class])->group(function ()
    {
        Route::prefix('categories')->group(function ()
        {
            Route::get('/', [CategoriesController::class, 'index']);
            Route::get('/show', [CategoriesController::class, 'show']);
            Route::post('/store', [CategoriesController::class, 'store']);
            Route::post('/update/{category}', [CategoriesController::class, 'update']);
            Route::get('/show/{category}', [CategoriesController::class, 'show']);
            Route::post('/delete/{category}', [CategoriesController::class, 'delete']);
        });


        Route::prefix('discounts')->group(function ()
        {
            Route::get('/', [discountsController::class, 'index']);
            Route::post('/store', [discountsController::class, 'store']);
            Route::post('/update', [discountsController::class, 'update']);
            Route::post('/delete/{id}', [discountsController::class, 'delete']);
        });

        Route::prefix('courses')->group(function ()
        {
            Route::get('/', [CoursesController::class, 'index']);
            Route::get('/get_copones', [CoursesController::class, 'get_copones']);
            Route::post('/store', [CoursesController::class, 'store']);
            Route::post('/update/{id}', [CoursesController::class, 'update']);
        });


        Route::prefix('course_detailes')->group(function ()
        {
            Route::get('/', [CoursesController::class, 'index']);
            Route::get('/get_copones', [CoursesController::class, 'get_copones']);
            Route::post('/store', [CoursesController::class, 'store']);
            Route::post('/update/{id}', [CoursesController::class, 'update']);
        });
    });

});