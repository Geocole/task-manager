<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    public function create(User $user): bool
    {
        return $user->is_admin; // ou autre règle
    }

    public function update(User $user, Project $project): bool
    {
        return $user->id === $project->owner_id; // ou logique similaire
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->is_admin;
    }
}
