<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Guest boleh submit
    }

    public function rules(): array
    {
        return [
            'nama_instansi' => 'required|string|max:255',
            'pic_nama'      => 'required|string|max:255',
            'pic_email'     => 'required|email|max:255',
            'pic_telp'      => 'required|string|max:20',
            'jml_peserta'   => 'required|integer|min:1',
            'tgl_mulai'     => 'required|date',
            'tgl_selesai'   => 'required|date|after:tgl_mulai',
            'file_surat'    => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_peserta'  => 'required|file|mimes:xlsx,xls|max:5120',
            'keterangan'    => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_instansi' => 'Nama Instansi',
            'pic_nama'      => 'Nama PIC',
            'pic_email'     => 'Email PIC',
            'pic_telp'      => 'No. HP PIC',
            'jml_peserta'   => 'Jumlah Peserta',
            'tgl_mulai'     => 'Tanggal Mulai',
            'tgl_selesai'   => 'Tanggal Selesai',
            'file_surat'    => 'Surat Permohonan',
            'file_peserta'  => 'File Daftar Peserta',
        ];
    }
}
