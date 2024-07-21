<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCplProdiRequest extends FormRequest
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
            'kode_cpl' => 'required',
            'aspek' => 'required',
            'deskripsi' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kode_cpl.required' => 'Kolom kode cpl harus di isi.',
            'aspek.required' => 'Kolom aspek harus di isi.',
            'deskripsi.required' => 'Kolom deskripsi harus di isi.',
        ];
    }
}
