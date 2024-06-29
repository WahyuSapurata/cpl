<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMataKuliahRequest extends FormRequest
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
            'uuid_dosen' => 'required',
            'kode_mk' => 'required|unique:mata_kuliahs,kode_mk',
            'mata_kuliah' => 'required',
            'sks' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'uuid_dosen.required' => 'Kolom dosen harus di isi.',
            'kode_mk.required' => 'Kolom kode mata kuliah harus di isi.',
            'kode_mk.unique' => 'kode mata kuliah sudah digunakan.',
            'mata_kuliah.required' => 'Kolom mata kuliah harus di isi.',
            'sks.required' => 'Kolom sks harus di isi.',
        ];
    }
}
