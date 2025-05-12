<?php

namespace App\Core\Infrastructure\Repositories\Eloquent;

use App\Core\Domain\Entities\Task;
use App\Core\Domain\Repositories\TaskRepositoryInterface;
use App\Models\Task as TaskModel;

class TaskRepository implements TaskRepositoryInterface
{
    public function findAll(): array
    {
        return TaskModel::all()
            ->map(function (TaskModel $model) {
                return new Task(
                    $model->id,
                    $model->title,
                    $model->description,
                    new \DateTime($model->due_date),
                    $model->completed
                );
            })
            ->toArray();
    }

    public function findById(int $id): ?Task
    {
        $model = TaskModel::find($id);

        if (!$model) {
            return null;
        }

        return new Task(
            $model->id,
            $model->title,
            $model->description,
            new \DateTime($model->due_date),
            $model->completed
        );
    }

    public function save(Task $task): Task
    {
        $data = [
            'title' => $task->title,
            'description' => $task->description,
            'due_date' => $task->dueDate->format('Y-m-d'),
            'completed' => $task->completed
        ];

        if ($task->id) {
            $model = TaskModel::findOrFail($task->id);
            $model->update($data);
        } else {
            $model = TaskModel::create($data);
        }

        return new Task(
            $model->id,
            $model->title,
            $model->description,
            new \DateTime($model->due_date),
            $model->completed
        );
    }

    public function delete(int $id): void
    {
        TaskModel::destroy($id);
    }
}