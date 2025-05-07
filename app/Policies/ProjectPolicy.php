<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

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

    public function view(User $user, Project $project): bool
    {
        return $user->is_admin
            || $user->id === $project->owner_id
            || $project->users->contains($user->id);
    }
}
