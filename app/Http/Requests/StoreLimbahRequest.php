<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLimbahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_penghasil'    => ['required', 'exists:users,id_user'],
            'kode_limbah'     => ['required', 'string', 'max:100'],
            'jenis_limbah'    => ['nullable', 'string', 'max:255'],
            'sifat_limbah'    => ['nullable', 'string', 'max:255'],
            'jumlah_limbah'   => ['required', 'numeric', 'min:0.01'],
            'satuan'          => ['required', 'string', 'max:20'],
            'tgl_rencana'     => ['required', 'date'],
            'no_manifest'     => ['nullable', 'string', 'max:100'],
            'nama_driver'     => ['nullable', 'string', 'max:255'],
            'jenis_kendaraan' => ['nullable', 'string', 'max:100'],
            'no_kendaraan'    => ['nullable', 'string', 'max:50'],
            'catatan'         => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_penghasil.required'  => 'Penghasil wajib dipilih.',
            'id_penghasil.exists'    => 'Penghasil tidak valid.',
            'kode_limbah.required'   => 'Kode limbah wajib diisi.',
            'jumlah_limbah.required' => 'Berat angkut wajib diisi.',
            'jumlah_limbah.min'      => 'Berat angkut harus lebih dari 0.',
            'tgl_rencana.required'   => 'Tanggal angkut wajib diisi.',
            'tgl_rencana.date'       => 'Format tanggal tidak valid.',
        ];
    }
}
