<?php

namespace App\Services\Task;

interface TaskServiceInterface
{
    public function getTasks(?int $projectId = null);

    public function store(array $data): void;

    public function update(int $id, array $data): void;

    public function delete(int $id): void;

    public function reorder(array $orderedIds): void;
}
