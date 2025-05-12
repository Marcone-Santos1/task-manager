<?php

namespace App\Core\Domain\Exceptions;

use Exception;

class TaskException extends Exception
{
    public static function notFound(int $id): self
    {
        return new self("Task with ID {$id} not found", 404);
    }

    public static function invalidDueDate(): self
    {
        return new self("Due date cannot be in the past", 422);
    }

    public static function invalidData(string $message): self
    {
        return new self($message, 422);
    }
}
