<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Teacher\CategoryService;
use App\Interfaces\Teacher\CategoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryInterface::class, CategoryService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
