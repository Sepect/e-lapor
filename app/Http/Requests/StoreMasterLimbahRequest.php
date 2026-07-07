<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMasterLimbahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'kode_limbah' => ['required', 'string', 'max:100', Rule::unique('master_limbahs', 'kode_limbah')->ignore($id, 'id_master_limbah')],
            'jenis_limbah' => ['required', 'string', 'max:255'],
            'sifat_limbah' => ['required', 'string', 'max:255'],
            'tarif' => ['required', 'numeric', 'min:0'],
            'satuan' => ['required', 'string', 'max:20'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'kode_limbah.required' => 'Kode limbah wajib diisi.',
            'kode_limbah.unique' => 'Kode limbah sudah terdaftar.',
            'jenis_limbah.required' => 'Jenis limbah wajib diisi.',
            'sifat_limbah.required' => 'Sifat limbah wajib diisi.',
            'tarif.required' => 'Tarif wajib diisi.',
            'tarif.min' => 'Tarif tidak boleh negatif.',
        ];
    }
}
