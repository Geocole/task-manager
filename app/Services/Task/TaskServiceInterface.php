<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskServiceInterface
{
    public function getUserTasks(?int $projectId = null): Collection;
    public function getProjectTasks(?int $projectId = null): Collection;
    public function countUserTasks(): int;
    public function countTodayTasks(): int;
    public function store(array $data): Task;

    public function update(int $id, array $data): void;

    public function delete(int $id): void;

    public function reorder(array $orderedIds): array;
}
