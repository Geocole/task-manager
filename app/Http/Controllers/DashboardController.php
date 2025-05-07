<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Dashboard', [
            'projectCount' => Project::count(),
            'taskCount' => Task::count(),
            'tasksToday' => Task::whereDate('due_date', now()->toDateString())->count(),
            'auth' => [
                'user' => auth()->user()->load('roles'),
            ],
        ]);
    }
}
