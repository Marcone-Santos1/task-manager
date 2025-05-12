<?php

namespace App\Core\Application\DTOs;

class CreateTaskDto
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $dueDate
    ) {}
}