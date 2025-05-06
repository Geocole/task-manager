<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\Task\TaskServiceInterface;

class DeleteController extends Controller
{
    public function __construct(private TaskServiceInterface $service) {}

    public function __invoke(Task $task)
    {
        $this->authorize('delete', $task);

        $this->service->delete($task->id);

        return redirect()->back()->with('success', 'Task deleted.');
    }
}
