<?php

declare(strict_types=1);

namespace App\Services\Project;

use App\Models\Project;

interface ProjectServiceInterface
{
    public function store(array $data): Project;
    public function update(int $id, array $data): Project;
    public function delete(int $id): void;
    public function list(): array;
    public function count(): int;
}
