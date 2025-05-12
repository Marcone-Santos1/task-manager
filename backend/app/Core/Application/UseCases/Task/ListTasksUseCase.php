<?php

namespace App\Core\Application\UseCases\Task;

use App\Core\Application\DTOs\TaskDto;
use App\Core\Domain\Repositories\TaskRepositoryInterface;

class ListTasksUseCase
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    public function execute(): array
    {
        $tasks = $this->taskRepository->findAll();

        return array_map(function ($task) {
            return new TaskDto(
                $task->id,
                $task->title,
                $task->description,
                $task->dueDate->format('Y-m-d'),
                $task->completed
            );
        }, $tasks);
    }
}