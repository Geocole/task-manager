<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'priority' => 'required|integer|min:1',
            'status' => 'required|in:pending,in_progress,done',
            'due_date' => 'nullable|date|after_or_equal:today',
            'is_blocker' => 'boolean',
        ];
    }
}
