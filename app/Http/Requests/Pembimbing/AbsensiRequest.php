<?php

namespace App\Http\Requests\Pembimbing;

use Illuminate\Foundation\Http\FormRequest;

class AbsensiRequest extends FormRequest
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
            'tanggal'     => 'required|date',
            'status'      => 'required|in:hadir,izin,sakit,alpa',
            'keterangan'  => 'nullable|string|max:500',
        ];
    }

    public function attributes(): array
    {
        return [
            'peserta_id' => 'Peserta',
            'tanggal'    => 'Tanggal',
            'status'     => 'Status',
        ];
    }
}
