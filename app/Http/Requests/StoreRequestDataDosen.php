<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestDataDosen extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_dosen' => 'required|unique:users,kode_dosen',
            'name' => 'required',
            'nip' => 'required',
            'username' => 'required|unique:users,username',
        ];
    }

    public function messages()
    {
        return [
            'kode_dosen.required' => 'Kolom kode dosen harus di isi.',
            'username.unique' => 'kode dosen sudah digunakan oleh pengguna lain.',
            'name.required' => 'Kolom nama harus di isi.',
            'nip.required' => 'Kolom nip harus di isi.',
            'username.required' => 'Kolom username harus di isi.',
            'username.unique' => 'username sudah digunakan oleh pengguna lain.',
        ];
    }
}
