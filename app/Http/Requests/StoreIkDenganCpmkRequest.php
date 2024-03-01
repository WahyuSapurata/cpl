<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIkDenganCpmkRequest extends FormRequest
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
            'kode_cpmk' => 'required',
            'deskripsi' => 'required',
            'bobot' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kode_cpmk.required' => 'Kolom kode cpmk harus di isi.',
            'deskripsi.required' => 'Kolom deskripsi harus di isi.',
            'bobot.required' => 'Kolom bobot harus di isi.',
        ];
    }
}
