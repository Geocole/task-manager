<?php

declare(strict_types=1);

namespace App\Services\Project;

use App\Models\Project;

class ProjectService implements ProjectServiceInterface
{
    public function store(array $data): void
    {
        Project::create($data);
    }

    public function update(int $id, array $data): void
    {
        $project = Project::findOrFail($id);
        $project->update($data);
    }

    public function delete(int $id): void
    {
        Project::findOrFail($id)->delete();
    }

    public function list(): array
    {
        return Project::withCount('tasks')->get()->toArray();
    }
}
