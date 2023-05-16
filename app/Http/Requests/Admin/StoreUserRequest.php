<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|numeric',
            'branch_id' => [Rule::requiredIf($this->role == \Role::REGIONAL_MANAGER), 'exists:branches,id'],
            'department_id' => [Rule::requiredIf($this->role == \Role::HEAD_MANAGER), 'exists:departments,id'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = $this->validator->validated();
        $data['password'] = Hash::make($this->post('password'));
        return $data;
    }
}
