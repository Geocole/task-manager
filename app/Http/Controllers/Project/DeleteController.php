<?php

declare(strict_types=1);

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\Project\ProjectServiceInterface;
use Illuminate\Support\Facades\Gate;

class DeleteController extends Controller
{
    public function __construct(private ProjectServiceInterface $service)
    {
    }

    public function __invoke(Project $project)
    {
        if (Gate::denies('delete', $project)) {
            abort(403);
        }
        $this->service->delete($project->id);

        return redirect()->route('projects.index')->with('success', 'Project deleted.');
    }
}
