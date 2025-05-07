<?php

declare(strict_types=1);

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Services\Project\ProjectServiceInterface;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __construct(private ProjectServiceInterface $projectService)
    {
    }

    public function __invoke()
    {
        $projects = $this->projectService->list();

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
            'auth' => [
                'user' => auth()->user()->load('roles'),
            ],
        ]);
    }
}
