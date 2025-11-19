<?php

namespace App\Providers;

use App\Services\Teacher\CourseService;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Teacher\CourseInterface;
use App\Services\Teacher\CourseDetailesService;
use App\Interfaces\Teacher\CourseDetailesInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CourseInterface::class, CourseService::class);
        $this->app->bind(CourseDetailesInterface::class, CourseDetailesService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
