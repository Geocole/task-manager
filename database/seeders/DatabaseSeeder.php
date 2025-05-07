<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);

        // Admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);

        $permissions = [
            'create tasks',
            'update tasks',
            'delete tasks',
            'view tasks',
            'reorder tasks',
        ];

        $admin->assignRole('admin');
        $admin->givePermissionTo($permissions);

        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('user');
            $user->givePermissionTo(['view tasks', 'create tasks']);
        });

        $this->call([
            ProjectSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
