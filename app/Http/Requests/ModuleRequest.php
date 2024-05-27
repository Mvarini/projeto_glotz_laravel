<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
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
            'course_id' => 'required_if:course_id,!=,null',
            'name' => 'required|max:255',
            'hour' => 'nullable|numeric|gt:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name' => [
                'required' => 'O campo nome é obrigatório',
                'max' => 'O campo nome aceita no máximo :max caracteres',
            ],
            'hour' => [
                'numeric' => 'O campo duração aceita somente números',
                'gt' => 'O campo duração aceita somente número maior que zero'
            ],
            'course_id.required_if' => 'Relacionamento com a tabela cursos é inválido!'
        ];
    }
}
