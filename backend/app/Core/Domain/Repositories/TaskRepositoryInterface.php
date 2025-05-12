<?php

namespace App\Core\Domain\Repositories;

use App\Core\Domain\Entities\Task;

interface TaskRepositoryInterface
{
    public function findAll(): array;
    public function findById(int $id): ?Task;
    public function save(Task $task): Task;
    public function delete(int $id): void;
}