<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\Task\TaskServiceInterface;
use Illuminate\Support\Facades\Gate;

class DeleteController extends Controller
{
    public function __construct(private TaskServiceInterface $service)
    {
    }

    public function __invoke(Task $task)
    {
        if (Gate::denies('delete', $task)) {
            abort(403);
        }
        $this->service->delete($task->id);

        return redirect()->back()->with('success', 'Task deleted.');
    }
}
