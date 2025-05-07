<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Services\Task\TaskServiceInterface;

class UpdateController extends Controller
{
    public function __construct(private TaskServiceInterface $service)
    {
    }

    public function __invoke(UpdateTaskRequest $request, Task $task)
    {

        $this->service->update($task->id, $request->validated());

        return redirect()->back()->with('success', 'Task updated successfully.');
    }
}
