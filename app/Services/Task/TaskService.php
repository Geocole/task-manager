<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TaskService implements TaskServiceInterface
{
    public function getProjectTasks(?int $projectId = null): Collection
    {
        return Task::where('project_id', $projectId)->get();
    }
    public function getUserTasks(?int $projectId = null): Collection
    {
        $user = $this->getUser();

        if ($user->hasRole('admin')) {
            return Task::with('project')
                ->where('user_id', $user->id)
                ->when($projectId, fn ($query) => $query->where('project_id', $projectId))
                ->orderBy('priority')
                ->get();
        }

        return Task::with('project')
            ->where('user_id', $user->id)
            ->when($projectId, fn ($query) => $query->where('project_id', $projectId))
            ->orderBy('priority')
            ->get();

    }
    public function countUserTasks(): int
    {
        return $this->getUserTasks()->count();
    }

    public function countTodayTasks(): int
    {
        $user = $this->getUser();

        if ($user->hasRole('admin')) {
            return Task::whereDate('due_date', now()->toDateString())->count();
        }

        return Task::with('project')
            ->where('user_id', $user->id)
            ->count();
    }
    public function store(array $data): Task
    {
        $data['user_id'] = $this->getUser()->id;

        return Task::create($data);
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

    public function getUser(): User
    {
        return Auth::user();
    }
}
