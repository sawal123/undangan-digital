<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return $this->user()->hasAnyRole(['Owner']);
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
            'namaPaket'=> ['required','string','max:255'],
            'price'=> ['required','numeric'],
            'deskripsi'=> ['required'], // Validasi deskripsi sebagai string JSON
            'type' => ['required', 'in:persen,rupiah'],
            'diskon' => ['required', 'numeric'],
            'keterangan'=> ['required','string', 'max:255'],
        ];
    }
}
