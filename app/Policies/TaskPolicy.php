<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine if the user can create a new task.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('create tasks');
    }

    /**
     * Determine if the user can update the task.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can delete the task.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can reorder the task.
     */
    public function reorder(User $user, Task $task): bool
    {
        $project = $task->project;

        if (!$project) {
            return false;
        }

        if ($user->hasRole('admin')) {
            return $project->status !== 'completed';
        }

        return $project->status !== 'completed' && $user->projects()->where('id', $project->id)->exists();
    }
}
