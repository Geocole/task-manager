<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Services\Project\ProjectServiceInterface;

class UpdateController extends Controller
{
    public function __construct(private ProjectServiceInterface $service) {}

    public function __invoke(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $this->service->update($project->id, $request->validated());

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }
}
