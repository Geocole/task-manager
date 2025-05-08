<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Project\ProjectService;
use App\Services\Task\TaskService;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(
        protected TaskService $taskService,
        protected ProjectService $projectService
    ) {
    }

    public function __invoke()
    {
        return Inertia::render('Dashboard', [
            'projectCount' => $this->projectService->count(),
            'taskCount' => $this->taskService->countUserTasks(),
            'tasksToday' => $this->taskService->countTodayTasks(),
            'auth' => [
                'user' => auth()->user()->load('roles'),
            ],
        ]);
    }
}
