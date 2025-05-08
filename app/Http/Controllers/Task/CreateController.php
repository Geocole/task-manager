<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Models\Task;
use App\Services\Task\TaskServiceInterface;
use Illuminate\Support\Facades\Gate;

class CreateController extends Controller
{
    public function __construct(private TaskServiceInterface $service)
    {
    }

    public function __invoke(StoreTaskRequest $request)
    {
        if (Gate::denies('create', Task::class)) {
            abort(403);
        }

        $task = $this->service->store($request->validated());

        return redirect()->back()->with([
            'success' => 'Task created successfully.',
            'newTask' => $task,
        ]);
    }
}
