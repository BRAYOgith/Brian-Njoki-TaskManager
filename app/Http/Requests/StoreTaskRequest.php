<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Task;
use Carbon\Carbon;

class StoreTaskRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('title')) {
            $this->merge(['title' => strip_tags($this->title)]);
        }
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',

                Rule::unique('tasks')->where(function ($query) {
                    return $query->where('due_date', $this->due_date);
                }),
            ],
            'due_date' => [
                'required',
                'date',
                'after_or_equal:today', 
            ],
            'priority' => [
                'required',
                Rule::in(Task::PRIORITIES), 
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.unique' => 'A task with this title already exists for the selected dates.',
            'start_date.before_or_equal' => 'Start date must be before or equal to the due date.',
            'due_date.after_or_equal' => 'Due date must be after or equal to the start date.',
            'priority.in' => 'Priority must be low, medium, or high.',
        ];
    }
}
