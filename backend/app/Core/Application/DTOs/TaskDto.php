<?php

namespace App\Core\Application\DTOs;

class TaskDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $dueDate,
        public readonly bool $completed
    ) {}
}