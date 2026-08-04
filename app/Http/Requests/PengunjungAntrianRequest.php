<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengunjungAntrianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'       => 'required|string|max:100',
            'instansi'   => 'required|string|max:150',
            'no_hp'      => 'required|string|max:20',
            'layanan_id' => 'required|exists:layanans,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'       => 'Nama pengunjung wajib diisi.',
            'instansi.required'   => 'Instansi wajib diisi.',
            'no_hp.required'      => 'Nomor HP wajib diisi.',
            'layanan_id.required' => 'Silakan pilih jenis layanan.',
            'layanan_id.exists'   => 'Layanan yang dipilih tidak valid.',
        ];
    }
}