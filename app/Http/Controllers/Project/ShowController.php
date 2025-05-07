<?php

declare(strict_types=1);

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ShowController extends Controller
{
    public function __invoke(Project $project)
    {
        if (Gate::denies('view', $project)) {
            abort(403);
        }
        $project->load('tasks');

        return Inertia::render('Projects/Show', [
            'project' => $project,
        ]);
    }
}
