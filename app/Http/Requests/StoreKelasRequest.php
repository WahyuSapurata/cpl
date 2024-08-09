<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKelasRequest extends FormRequest
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
            'uuid_mahasiswa' => 'required',
            'uuid_matkul' => 'required',
            'kelas' => 'required',
            'tahun_ajaran' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'uuid_mahasiswa.required' => 'Kolom mahasiswa harus di isi.',
            'uuid_matkul.required' => 'Kolom mata kuliah harus di isi.',
            'kelas.required' => 'Kolom kelas harus di isi.',
            'tahun_ajaran.required' => 'Kolom tahun ajaran harus di isi.',
        ];
    }
}
