<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->paragraph(),
            'client_name' => $this->faker->company(),
            'project_manager' => $this->faker->name(),
            'budget' => $this->faker->randomFloat(2, 5000, 100000),
            'status' => $this->faker->randomElement(['planned', 'in_progress', 'completed', 'on_hold']),
            'start_date' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+3 months'),
            'delivery_date' => $this->faker->dateTimeBetween('+1 week', '+6 months'),
            'location' => $this->faker->city(),
            'category' => $this->faker->randomElement(['construction', 'tech', 'event', 'design']),
            'code' => strtoupper($this->faker->bothify('PRJ-###??')),
        ];
    }
}
