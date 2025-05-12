<?php

namespace Database\Factories;

use App\Domain\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->optional()->paragraph,
            'due_date' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
            'completed' => $this->faker->boolean(20),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function completed(): self
    {
        return $this->state([
            'completed' => true,
        ]);
    }

    public function incomplete(): self
    {
        return $this->state([
            'completed' => false,
        ]);
    }

    public function overdue(): self
    {
        return $this->state([
            'due_date' => $this->faker->dateTimeBetween('-1 month', '-1 day'),
            'completed' => false,
        ]);
    }
}
