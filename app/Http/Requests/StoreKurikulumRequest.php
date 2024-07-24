<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKurikulumRequest extends FormRequest
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
            'kode' => 'required',
            'nama' => 'required',
            'tahun_mulai' => 'required',
            'tahun_berakhir' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kode.required' => 'Kolom kode harus di isi.',
            'nama.required' => 'Kolom nama harus di isi.',
            'tahun_mulai.required' => 'Kolom tahun mulai harus di isi.',
            'tahun_berakhir.required' => 'Kolom tahun berakhir harus di isi.',
        ];
    }
}
