<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Models\Project;
use App\Services\Project\ProjectServiceInterface;

class StoreController extends Controller
{
    public function __construct(private ProjectServiceInterface $service) {}

    public function __invoke(StoreProjectRequest $request)
    {
        $this->authorize('create', Project::class);

        $this->service->store($request->validated());

        return redirect()->route('projects.index')->with('success', 'Project created successfully');
    }
}
