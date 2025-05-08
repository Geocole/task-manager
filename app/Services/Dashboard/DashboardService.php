<?php

declare(strict_types=1);

namespace App\Services\Dashboard;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    /**
     * Get dashboard statistics for the current user.
     *
     * @return array
     */
    public function getDashboardData(): array
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return [
                'projectCount' => Project::count(),
                'taskCount' => Task::count(),
                'tasksToday' => Task::whereDate('due_date', now()->toDateString())->count(),
            ];
        }

        return [
            'projectCount' => Project::where('owner_id', $user->id)->count(),
            'taskCount' => Task::where('user_id', $user->id)->count(),
            'tasksToday' => Task::where('user_id', $user->id)
                ->whereDate('due_date', now()->toDateString())->count(),
        ];
    }
}
