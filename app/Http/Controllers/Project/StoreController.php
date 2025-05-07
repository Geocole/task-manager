<?php

declare(strict_types=1);

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Services\Project\ProjectServiceInterface;
use Illuminate\Support\Facades\Gate;

class StoreController extends Controller
{
    public function __construct(private ProjectServiceInterface $service)
    {
    }

    public function __invoke(StoreProjectRequest $request)
    {
        if (Gate::denies('create', $project)) {
            abort(403);
        }
        $this->service->store($request->validated());

        return redirect()->route('projects.index')->with('success', 'Project created successfully');
    }
}
