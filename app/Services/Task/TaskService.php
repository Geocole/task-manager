<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Models\Task;
use Exception;

class TaskService implements TaskServiceInterface
{
    public function getTasks(?int $projectId = null)
    {
        return Task::with('project')
            ->when($projectId, fn ($query) => $query->where('project_id', $projectId))
            ->orderBy('priority')
            ->get();
    }

    public function store(array $data): void
    {
        Task::create($data);
    }

    public function update(int $id, array $data): void
    {
        $task = Task::findOrFail($id);
        $task->update($data);
    }

    public function delete(int $id): void
    {
        Task::findOrFail($id)->delete();
    }

    public function reorder(array $orderedIds): array
    {
        try {
            foreach ($orderedIds as $index => $id) {
                Task::where('id', $id)->update(['priority' => $index + 1]);
            }
            return ['success', 'Tasks reordered successfully.'];
        } catch (Exception $ex) {
            return ['error', $ex->getMessage()];
        }
    }
}
