<?php

declare(strict_types=1);

namespace App\Services\Project;

interface ProjectServiceInterface
{
    public function store(array $data): void;
    public function update(int $id, array $data): void;
    public function delete(int $id): void;
    public function list(): array;
}
