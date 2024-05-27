<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'signature' => 'nullable|mimes:jpeg,jpg,png|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name'=> [
                'required' => 'O campo nome é obrigatório',
                'max' => 'O campo nome aceita no máximo :max caracteres'
            ],
            'last_name' => [
                'required' => 'O campo sobrenome é obrigatório',
                'max' => 'O campo sobrenome aceita no máximo :max caracteres'
            ],
            'signature' => [
                'mimes' => 'O campo assinatura aceita somente os formatos jpeg, jpg ou png',
                'max' => 'O campo assintura aceita somente o tamanho de 4M'
            ],
        ];
    }
}
