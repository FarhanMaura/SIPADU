<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'role'     => 'required|integer|in:1,2,3',
            'password' => $this->isMethod('POST') ? 'required|string|min:8' : 'nullable|string|min:8',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'     => 'Nama',
            'email'    => 'Email',
            'role'     => 'Role',
            'password' => 'Password',
        ];
    }
}
