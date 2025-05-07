<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ReorderTasksRequest extends FormRequest
{
    public function authorize(): bool
    {
        $taskIds = $this->input('tasks');
        $projectId = $this->input('project_id');

        $tasks = Task::whereIn('id', $taskIds)->get();
        $project = Project::find($projectId);

        foreach ($tasks as $task) {
            if (!Gate::allows('reorder', [$task, $project])) {
                return false;
            }
        }

        return true;
    }

    public function rules(): array
    {
        return [
            'tasks' => ['required', 'array'],
            'tasks.*' => ['integer', 'exists:tasks,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'tasks.required' => 'No ID provided.',
            'tasks.*.exists' => 'Task not available',
        ];
    }
}
