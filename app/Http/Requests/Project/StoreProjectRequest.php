<?php

declare(strict_types=1);

namespace App\Http\Requests\Project;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'client_name' => ['required', 'string'],
            'project_manager' => ['nullable', 'string'],
            'budget' => ['nullable', 'numeric'],
            'status' => ['required', 'in:planned,in_progress,completed,on_hold'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'delivery_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string'],
            'category' => ['nullable', 'string'],
            'code' => ['required', 'string', 'unique:projects,code'],
        ];
    }
}
