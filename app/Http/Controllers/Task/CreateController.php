<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Services\Task\TaskServiceInterface;

class CreateController extends Controller
{
    public function __construct(private TaskServiceInterface $service) {}

    public function __invoke(StoreTaskRequest $request)
    {
        $this->authorize('create', \App\Models\Task::class);

        $this->service->store($request->validated());

        return redirect()->back()->with('success', 'Task created successfully.');
    }
}
