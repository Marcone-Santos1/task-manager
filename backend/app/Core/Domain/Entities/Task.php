<?php

namespace App\Core\Domain\Entities;

use DateTime;

class Task
{
    public function __construct(
        public ?int $id,
        public string $title,
        public ?string $description,
        public DateTime $dueDate,
        public bool $completed = false
    ) {}
}