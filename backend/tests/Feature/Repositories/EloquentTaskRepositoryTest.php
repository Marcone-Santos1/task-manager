<?php

namespace Tests\Feature\Repositories;

use App\Core\Domain\Entities\Task;
use App\Core\Infrastructure\Repositories\Eloquent\TaskRepository as EloquentTaskRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentTaskRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentTaskRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentTaskRepository();
    }

    public function test_all_returns_empty_collection_when_no_tasks()
    {
        $tasks = $this->repository->findAll();
        $this->assertEmpty($tasks);
    }

    public function test_all_returns_tasks_ordered_by_due_date()
    {
        $task1 = \App\Models\Task::factory()->create(['title' => '1', 'due_date' => now()->addDays(3)]);
        $task2 = \App\Models\Task::factory()->create(['title' => '2', 'due_date' => now()->addDays(1)]);
        $task3 = \App\Models\Task::factory()->create(['title' => '3', 'due_date' => now()->addDays(2)]);

        $tasks = $this->repository->findAll();

        $this->assertCount(3, $tasks);
        $this->assertEquals($task2->id, $tasks[0]->getId());
        $this->assertEquals($task3->id, $tasks[1]->getId());
        $this->assertEquals($task1->id, $tasks[2]->getId());
    }

    public function test_find_returns_null_when_task_not_found()
    {
        $task = $this->repository->findById(999);
        $this->assertNull($task);
    }

    public function test_find_returns_task_when_exists()
    {
        $model = \App\Models\Task::factory()->create();
        $task = $this->repository->findById($model->id);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals($model->title, $task->getTitle());
    }

    public function test_create_task()
    {
        $task = new Task(
            id: null,
            title: 'Nova tarefa',
            description: 'Descrição',
            dueDate: Carbon::tomorrow()
        );

        $createdTask = $this->repository->save($task);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Nova tarefa',
            'description' => 'Descrição',
        ]);
        $this->assertNotNull($createdTask->getId());
    }

    public function test_update_task()
    {
        $model = \App\Models\Task::factory()->create(['title' => 'Título antigo']);

        $task = new Task(
            id: $model->id,
            title: 'Nova tarefa',
            description: 'Descrição',
            dueDate: Carbon::tomorrow()
        );

        $updatedTask = $this->repository->save($task);

        $this->assertEquals('Nova tarefa', $updatedTask->getTitle());
        $this->assertDatabaseHas('tasks', [
            'id' => $model->id,
            'title' => 'Nova tarefa',
        ]);
    }

    public function test_delete_task()
    {
        $model = \App\Models\Task::factory()->create();
        $this->repository->delete($model->id);

        $this->assertDatabaseMissing('tasks', ['id' => $model->id, 'deleted_at' => $model->deleted_at]);
    }
}
