<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BidangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama'      => 'Nama Bidang',
            'deskripsi' => 'Deskripsi',
        ];
    }
}
