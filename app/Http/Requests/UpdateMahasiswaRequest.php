<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMahasiswaRequest extends FormRequest
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
            'nim' => 'required|unique:mahasiswas,nim,' . $this->route('params') . ',uuid',
            'nama' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nim.required' => 'Kolom nim harus di isi.',
            'nim.unique' => 'nim sudah digunakan oleh pengguna lain.',
            'nama.required' => 'Kolom nama harus di isi.',
        ];
    }
}
