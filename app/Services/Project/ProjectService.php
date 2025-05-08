<?php

declare(strict_types=1);

namespace App\Services\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectService implements ProjectServiceInterface
{
    /**
     * Store a new project.
     *
     * @param array $data
     * @return Project
     */
    public function store(array $data): Project
    {
        $user = Auth::user();

        $project = Project::create($data);

        $project->users()->attach($user->id);

        return $project;
    }

    /**
     * Update an existing project.
     *
     * @param int $id
     * @param array $data
     * @return Project
     */
    public function update(int $id, array $data): Project
    {
        $project = Project::findOrFail($id);
        $project->update($data);

        return $project;
    }

    /**
     * Delete a project.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Project::findOrFail($id)->delete();
    }

    /**
     * Get the list of projects with their task count.
     *
     * @return array
     */
    public function list(): array
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return Project::withCount('tasks')->get()->toArray();
        }

        return $user->projects()->withCount('tasks')->get()->toArray();
    }

    /**
     * Count the number of projects for the authenticated user.
     *
     * @return int
     */
    public function count(): int
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return Project::count();
        }

        return $user->projects()->count();
    }
}
