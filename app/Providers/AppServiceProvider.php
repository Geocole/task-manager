<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Project\ProjectService;
use App\Services\Project\ProjectServiceInterface;
use App\Services\Task\TaskService;
use App\Services\Task\TaskServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProjectServiceInterface::class,
            ProjectService::class
        );
        $this->app->bind(
            TaskServiceInterface::class,
            TaskService::class
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
