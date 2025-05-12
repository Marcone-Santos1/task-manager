<?php

namespace App\Core\Application\UseCases\Task;

use App\Core\Application\DTOs\TaskDto;
use App\Core\Domain\Entities\Task;
use App\Core\Domain\Exceptions\TaskException;
use App\Core\Domain\Repositories\TaskRepositoryInterface;

class GetTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    public function execute(int $id): TaskDto
    {
        $task = $this->taskRepository->findById($id);

        if (!$task) {
            throw TaskException::notFound($id);
        }

        return new TaskDto(
            $task->id,
            $task->title,
            $task->description,
            $task->dueDate->format('Y-m-d'),
            $task->completed
        );
    }
}
