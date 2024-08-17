<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubCpmkRequest extends FormRequest
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
            'uuid_cpmk' => 'required',
            'nama_sub' => 'required',
            'deskripsi' => 'required',
            'bobot' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'uuid_cpmk.required' => 'Kolom cpmk harus di isi.',
            'nama_sub.required' => 'Kolom nama sub harus di isi.',
            'deskripsi.required' => 'Kolom deskripsi harus di isi.',
            'bobot.required' => 'Kolom bobot harus di isi.',
        ];
    }
}
