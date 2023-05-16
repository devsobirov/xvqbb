<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    protected $user;

    public function authorize(): bool
    {
        return !$this->getUpdatingUser()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->getUpdatingUser()->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|numeric',
            'branch_id' => [Rule::requiredIf($this->role == \Role::REGIONAL_MANAGER), 'exists:branches,id'],
            'department_id' => [Rule::requiredIf($this->role == \Role::HEAD_MANAGER), 'exists:departments,id'],
        ];
    }

    protected function getUpdatingUser(): ?User
    {
        if (!$this->user) {
            $this->user = $this->route()->parameter('user');
        }
        return $this->user;
    }

    protected function prepareForValidation()
    {
        if ($this->password == null) {
            $this->request->remove('password');
        }
    }

    public function validated($key = null, $default = null)
    {
        $data = $this->validator->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($this->post('password'));
        }
        return $data;
    }
}
