<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowController extends Controller
{
    public function __invoke(Project $project)
    {
        $this->authorize('view', $project);

        $project->load('tasks');

        return Inertia::render('Projects/Show', [
            'project' => $project,
        ]);
    }
}
