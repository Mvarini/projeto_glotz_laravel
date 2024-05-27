<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'teacher_id' => 'required_if:teacher_id,!=,null', // Se existir o campo teachear_id e for diferente de nulo
            'name' => 'required|max:255',
            'price' => 'required|max:8',
            'hour' => 'required|numeric|gt:0', //gt:0 -> maior que zero
            'cover' => 'image|mimes:jpg,jpeg,png|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo curso é obrigatório',
            'name.max' => 'O campo nome aceita no máximo :max caracteres',
            'price' => [
                'required' => 'O campo valor é obrigatorio',
                'numeric' => 'Digite apenas números para campo valor',
                'max' => 'O campo valor pode ter no máximo :max dígitos',
            ],
            'hour.required' => 'O campo duração é obrigatorio',
            'hour.gt' => 'O campo duração só aceita valor maior que zero',
            'cover.mimes' => 'O campo capa aceita somente formatos jpg, jpeg ou png',
            'cover.max' => 'O campo capa aceita imagem com tamanho de até 4M',
            'cover.image' => 'O campo capa aceita apenas imagens',
            'teacher_id.required_if' => 'Relacionamento com a tabela professor é inválido!'
        ];
    }
}
