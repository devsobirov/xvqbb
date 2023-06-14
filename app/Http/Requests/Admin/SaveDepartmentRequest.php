<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveDepartmentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }


    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'prefix' => 'required|alpha_dash|min:3|max:255|unique:departments,prefix,'.$this->department?->id
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'prefix' => strtolower($this->prefix),
        ]);
    }
}
