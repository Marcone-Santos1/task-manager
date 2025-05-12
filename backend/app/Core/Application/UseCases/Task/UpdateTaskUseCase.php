<?php

namespace App\Core\Application\UseCases\Task;

use App\Core\Application\DTOs\TaskDto;
use App\Core\Application\DTOs\UpdateTaskDto;
use App\Core\Domain\Entities\Task;
use App\Core\Domain\Exceptions\TaskException;
use App\Core\Domain\Repositories\TaskRepositoryInterface;

class UpdateTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    public function execute(int $id, UpdateTaskDto $dto): TaskDto
    {
        $existingTask = $this->taskRepository->findById($id);

        if (!$existingTask) {
            throw TaskException::notFound($id);
        }

        $task = new Task(
            $id,
            $dto->title ?? $existingTask->title,
            $dto->description ?? $existingTask->description,
            $dto->dueDate ? new \DateTime($dto->dueDate) : $existingTask->dueDate,
            $dto->completed ?? $existingTask->completed
        );

        $updatedTask = $this->taskRepository->save($task);

        return new TaskDto(
            $updatedTask->id,
            $updatedTask->title,
            $updatedTask->description,
            $updatedTask->dueDate->format('Y-m-d'),
            $updatedTask->completed
        );
    }
}
