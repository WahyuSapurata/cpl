<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIndikatorKinerjaRequest extends FormRequest
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
            'kode_ik' => 'required',
            'kemampuan' => 'required',
            'deskripsi' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kode_ik.required' => 'Kolom kode indikator kinerja harus di isi.',
            'kemampuan.required' => 'Kolom kemampuan harus di isi.',
            'deskripsi.required' => 'Kolom deskripsi harus di isi.',
        ];
    }
}
