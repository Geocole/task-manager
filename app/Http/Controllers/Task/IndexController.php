<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\Task\TaskService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __construct(private TaskService $taskService)
    {
    }

    public function __invoke(Request $request)
    {
        $projectId = $request->get('project_id');

        $tasks = $this->taskService->getUserTasks((int)$projectId);
        $projects = Project::orderBy('name')->get();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'projects' => $projects,
            'filters' => [
                'project_id' => $projectId,
            ],
            'auth' => [
                'user' => auth()->user()->load('roles'),
            ],
        ]);
    }
}
