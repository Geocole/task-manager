<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Services\Task\TaskServiceInterface;
use Illuminate\Http\Request;

class ReorderController extends Controller
{
    public function __construct(private TaskServiceInterface $service) {}

    public function __invoke(Request $request)
    {
        $this->authorize('reorder', \App\Models\Task::class);

        $request->validate([
            'ordered_ids' => 'required|array',
            'ordered_ids.*' => 'integer|exists:tasks,id',
        ]);

        $this->service->reorder($request->input('ordered_ids'));

        return response()->json(['message' => 'Tasks reordered successfully.']);
    }
}
