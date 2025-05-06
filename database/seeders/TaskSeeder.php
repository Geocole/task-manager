<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        Project::all()->each(function ($project) {
            Task::factory()->count(rand(3, 7))->create(['project_id' => $project->id]);
        });
    }
}
