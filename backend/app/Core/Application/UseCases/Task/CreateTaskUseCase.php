<?php

namespace App\Core\Application\UseCases\Task;

use App\Core\Application\DTOs\CreateTaskDto;
use App\Core\Application\DTOs\TaskDto;
use App\Core\Domain\Entities\Task;
use App\Core\Domain\Repositories\TaskRepositoryInterface;

class CreateTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    public function execute(CreateTaskDto $dto): TaskDto
    {
        $task = new Task(
            null,
            $dto->title,
            $dto->description,
            new \DateTime($dto->dueDate)
        );

        $savedTask = $this->taskRepository->save($task);

        return new TaskDto(
            $savedTask->id,
            $savedTask->title,
            $savedTask->description,
            $savedTask->dueDate->format('Y-m-d'),
            $savedTask->completed
        );
    }
}