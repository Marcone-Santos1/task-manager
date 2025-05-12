<?php

namespace App\Http\Controllers;

use App\Core\Application\DTOs\CreateTaskDto;
use App\Core\Application\DTOs\UpdateTaskDto;
use App\Core\Application\UseCases\Task\CreateTaskUseCase;
use App\Core\Application\UseCases\Task\DeleteTaskUseCase;
use App\Core\Application\UseCases\Task\GetTaskUseCase;
use App\Core\Application\UseCases\Task\ListTasksUseCase;
use App\Core\Application\UseCases\Task\UpdateTaskUseCase;
use App\Http\Resources\TaskResource;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\JsonResponse;

class TaskController
{
    public function __construct(
        private readonly ListTasksUseCase  $listTasksUseCase,
        private readonly CreateTaskUseCase $createTaskUseCase,
        private readonly GetTaskUseCase    $getTaskUseCase,
        private readonly UpdateTaskUseCase $updateTaskUseCase,
        private readonly DeleteTaskUseCase $deleteTaskUseCase
    ) {}

    public function index(): JsonResponse
    {
        $tasks = $this->listTasksUseCase->execute();
        return response()->json(TaskResource::collection($tasks));
    }

    public function store(CreateTaskRequest $request): JsonResponse
    {
        $dto = new CreateTaskDto(
            $request->input('title'),
            $request->input('description'),
            $request->input('due_date')
        );

        $task = $this->createTaskUseCase->execute($dto);
        return response()->json(new TaskResource($task), 201);
    }

    public function show(int $id): JsonResponse
    {
        $task = $this->getTaskUseCase->execute($id);
        return response()->json(new TaskResource($task));
    }

    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        $dto = new UpdateTaskDto(
            $request->input('title'),
            $request->input('description'),
            $request->input('due_date'),
            $request->input('completed')
        );

        $task = $this->updateTaskUseCase->execute($id, $dto);
        return response()->json(new TaskResource($task));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->deleteTaskUseCase->execute($id);
        return response()->json(null, 204);
    }
}
