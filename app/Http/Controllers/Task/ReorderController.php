<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\ReorderTasksRequest;
use App\Services\Task\TaskServiceInterface;

class ReorderController extends Controller
{
    public function __construct(private TaskServiceInterface $service)
    {
    }

    public function __invoke(ReorderTasksRequest $request)
    {
        [$key, $message] = $this->service->reorder($request->input('tasks'));

        return redirect()->route('tasks.index')->with($key, $message);
    }
}
