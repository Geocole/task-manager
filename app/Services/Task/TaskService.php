<?php

namespace App\Services\Task;

use App\Models\Task;

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

    public function reorder(array $orderedIds): void
    {
        foreach ($orderedIds as $index => $id) {
            Task::where('id', $id)->update(['priority' => $index + 1]);
        }
    }
}
