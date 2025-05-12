<?php

namespace Tests\Unit\Domain\Entities;

use App\Core\Domain\Entities\Task;
use Carbon\Carbon;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public function test_create_task_with_valid_data()
    {
        $task = new Task(
            id: null,
            title: 'Tarefa importante',
            description: 'Descrição detalhada',
            dueDate: Carbon::tomorrow(),
            completed: false
        );

        $this->assertEquals('Tarefa importante', $task->getTitle());
        $this->assertEquals('Descrição detalhada', $task->getDescription());
        $this->assertFalse($task->isCompleted());
    }

    public function test_throws_exception_for_empty_title()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Title cannot be empty');

        new Task(
            id: null,
            title: '',
            description: 'Descrição',
            dueDate: Carbon::tomorrow()
        );
    }

    public function test_mark_task_as_completed()
    {
        $task = new Task(
            id: 1,
            title: 'Tarefa',
            description: 'Descrição',
            dueDate: Carbon::tomorrow(),
            completed: false
        );

        $task->markAsCompleted();
        $this->assertTrue($task->isCompleted());
    }

    public function test_is_overdue()
    {
        $task = new Task(
            id: 1,
            title: 'Tarefa',
            description: 'Descrição',
            dueDate: Carbon::yesterday(),
            completed: false
        );

        $this->assertTrue($task->isOverdue());
    }
}
