<?php

namespace App\Core\Domain\Entities;

use DateTime;

class Task
{
    /**
     * @throws \Exception
     */
    public function __construct(
        public ?int $id,
        public string $title,
        public ?string $description,
        public DateTime $dueDate,
        public bool $completed = false
    ) {

        $this->validate();

    }

    /**
     * @throws \Exception
     */
    private function validate()
    {
        if (empty($this->title)) {
            throw new \InvalidArgumentException("Title cannot be empty");
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDueDate(): DateTime
    {
        return $this->dueDate;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function markAsCompleted(): void
    {
        $this->completed = true;
    }

    public function isOverdue(): bool
    {
        return $this->dueDate < new DateTime();
    }
}
