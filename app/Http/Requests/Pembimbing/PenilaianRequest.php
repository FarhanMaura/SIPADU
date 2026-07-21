<?php

namespace App\Http\Requests\Pembimbing;

use Illuminate\Foundation\Http\FormRequest;

class PenilaianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isPembimbing();
    }

    public function rules(): array
    {
        $pembimbingId = auth()->user()->pembimbing?->id;

        return [
            'peserta_id'  => [
                'required',
                \Illuminate\Validation\Rule::exists('pesertas', 'id')->where(function ($query) use ($pembimbingId) {
                    $query->where('pembimbing_id', $pembimbingId);
                }),
            ],
            'nilai_angka' => 'required|numeric|min:0|max:100',
            'keterangan'  => 'nullable|string|max:1000',
        ];
    }

    public function attributes(): array
    {
        return [
            'peserta_id'  => 'Peserta',
            'nilai_angka' => 'Nilai',
        ];
    }
}
