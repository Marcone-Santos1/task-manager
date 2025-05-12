<?php

namespace App\Core\Application\UseCases\Task;

use App\Core\Domain\Exceptions\TaskException;
use App\Core\Domain\Repositories\TaskRepositoryInterface;

class DeleteTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    public function execute(int $id): void
    {
        $task = $this->taskRepository->findById($id);

        if (!$task) {
            throw TaskException::notFound($id);
        }

        $this->taskRepository->delete($id);
    }
}
