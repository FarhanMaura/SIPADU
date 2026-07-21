<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InstansiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nama'   => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telp'   => 'nullable|string|max:20',
            'email'  => 'nullable|email|max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama'   => 'Nama Instansi',
            'alamat' => 'Alamat',
            'telp'   => 'No. Telepon',
            'email'  => 'Email',
        ];
    }
}
