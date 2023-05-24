<?php

namespace App\Http\Requests\Head;

use Illuminate\Foundation\Http\FormRequest;

class SaveTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'user_id' => 'required',
            'department_id' => 'required|exists:departments,id',
            'starts_at' => 'required|date|after_or_equal:' . date('Y-m-d'),
            'expires_at' => 'required|date|after:' . $this->starts_at,
            'note' => 'nullable|string'
        ];
    }
}
