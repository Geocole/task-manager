<?php

declare(strict_types=1);

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Services\Project\ProjectServiceInterface;
use Illuminate\Support\Facades\Gate;

class UpdateController extends Controller
{
    public function __construct(private ProjectServiceInterface $service)
    {
    }

    public function __invoke(UpdateProjectRequest $request, Project $project)
    {
        if (Gate::denies('update', $project)) {
            abort(403);
        }
        $this->service->update($project->id, $request->validated());

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }
}
