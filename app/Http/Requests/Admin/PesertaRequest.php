<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PesertaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'file_peserta' => 'required|file|mimes:xlsx,xls|max:5120',
            'pengajuan_id' => 'required|exists:pengajuans,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'file_peserta' => 'File Excel Peserta',
            'pengajuan_id' => 'Pengajuan',
        ];
    }
}
