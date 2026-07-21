<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PembimbingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $pembimbingId = $this->route('pembimbing')?->id;

        return [
            'nama'      => 'required|string|max:255',
            'bidang_id' => 'nullable|exists:bidangs,id',
            'nip'       => ['nullable', 'string', 'max:50', Rule::unique('pembimbings', 'nip')->ignore($pembimbingId)->whereNull('deleted_at')],
            'no_hp'     => 'nullable|string|max:20',
            'email'     => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->route('pembimbing')?->user_id)],
            'password'  => $this->isMethod('POST') ? 'required|string|min:8' : 'nullable|string|min:8',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama'      => 'Nama Pembimbing',
            'bidang_id' => 'Bidang',
            'nip'       => 'NIP',
            'no_hp'     => 'No. HP',
            'email'     => 'Email',
            'password'  => 'Password',
        ];
    }
}
