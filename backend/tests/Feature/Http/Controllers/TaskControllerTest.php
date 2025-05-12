<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_tasks()
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => ['id', 'title', 'description', 'due_date', 'completed']
            ]);
    }

    public function test_can_create_task()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'due_date' => now()->addWeek()->format('Y-m-d'),
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(201)
            ->assertJson($data);
    }

    public function test_validation_for_create_task()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => '',
            'due_date' => now()->subDay()->format('Y-m-d'),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_index_returns_empty_when_no_tasks()
    {
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(200)
            ->assertJsonCount(0);
    }

    public function test_index_returns_tasks_ordered_by_due_date()
    {
        $task1 = Task::factory()->create(['due_date' => now()->addDays(3)]);
        $task2 = Task::factory()->create(['due_date' => now()->addDays(1)]);
        $task3 = Task::factory()->create(['due_date' => now()->addDays(2)]);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonPath('0.id', $task2->id)
            ->assertJsonPath('1.id', $task3->id)
            ->assertJsonPath('2.id', $task1->id);
    }

    public function test_store_creates_new_task()
    {
        $data = [
            'title' => 'Nova tarefa',
            'description' => 'Descrição detalhada',
            'due_date' => now()->addDay()->format('Y-m-d'),
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(201)
            ->assertJson($data);

        $this->assertDatabaseHas('tasks', $data);
    }

    public function test_store_validates_required_fields()
    {
        $response = $this->postJson('/api/tasks', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'due_date']);
    }


    public function test_show_returns_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $task->id,
                'title' => $task->title,
            ]);
    }

    public function test_show_returns_404_when_not_found()
    {
        $response = $this->getJson('/api/tasks/999');
        $response->assertStatus(404);
    }

    public function test_update_modifies_existing_task()
    {
        $task = Task::factory()->create(['title' => 'Título antigo']);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Novo título',
            'due_date' => now()->addDays(2)->format('Y-m-d'),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $task->id,
                'title' => 'Novo título',
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Novo título',
        ]);
    }

    public function test_destroy_deletes_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id, 'deleted_at' => $task->deleted_at]);
    }

    public function test_complete_marks_task_as_completed()
    {
        $task = Task::factory()->completed()->create();

        $response = $this->putJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['completed' => true]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'completed' => true,
        ]);
    }

    public function test_incomplete_marks_task_as_incomplete()
    {
        $task = Task::factory()->incomplete()->create();

        $response = $this->putJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['completed' => false]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'completed' => false,
        ]);
    }
}
