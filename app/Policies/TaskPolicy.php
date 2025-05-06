<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('create tasks');
    }

    public function update(User $user, Task $task): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->hasRole('admin');
    }
}
