<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        Project::factory(10)->create()->each(function ($project) use ($users) {
            $owner = $users->random();
            $project->owner()->associate($owner)->save();

            $project->users()->sync($users->random(3)->pluck('id'));
        });
    }
}
