<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNilaiRequest extends FormRequest
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
            'uuid_mk' => 'required',
            'uuid_ik' => 'required',
            'uuid_cpl' => 'required',
            'uuid_cpmk' => 'required',
            'nilai' => 'required|regex:/^[0-9.]+$/',
        ];
    }

    public function messages()
    {
        return [
            'uuid_mk.required' => 'Kolom kode mata kuliah harus di isi.',
            'uuid_ik.required' => 'Kolom kode indikator kinerja harus di isi.',
            'uuid_cpl.required' => 'Kolom kode cpl harus di isi.',
            'uuid_cpmk.required' => 'Kolom kode cpmk harus di isi.',
            'nilai.required' => 'Kolom nilai harus di isi.',
            'nilai.regex' => 'Kolom nilai hanya boleh berisi angka dan titik.',
        ];
    }
}
