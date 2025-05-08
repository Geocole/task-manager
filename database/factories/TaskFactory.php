<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'done']),
            'priority' => $this->faker->numberBetween(1, 10),
            'due_date' => $this->faker->dateTimeBetween('now', '+2 months'),
            'is_blocker' => $this->faker->boolean(15),
            'project_id' => Project::factory(),
            'user_id' => User::factory(),
        ];
    }
}
