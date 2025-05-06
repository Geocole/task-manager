<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\Project\ProjectServiceInterface;

class DeleteController extends Controller
{
    public function __construct(private ProjectServiceInterface $service) {}

    public function __invoke(Project $project)
    {
        $this->authorize('delete', $project);

        $this->service->delete($project->id);

        return redirect()->route('projects.index')->with('success', 'Project deleted.');
    }
}
