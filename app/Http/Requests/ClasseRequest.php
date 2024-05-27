<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ClasseRequest extends FormRequest
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
        if (request()->isMethod('POST')) {
            return [
                'module_id' => 'required_if:module_id,!=,null',
                'name' => 'required|max:255',
                'video' => 'required|mimes:mp4,mov|max:1024000', // até 1GB
                'pdf' => 'mimes:pdf|max:7096', // unidade de medida kilobytes
            ];
        }else{
            return [
                'module_id' => 'required_if:module_id,!=,null',
                'name' => 'required|max:255',
                'video' => 'nullable|mimes:mp4,mov|max:1024000', // até 1GB
                'pdf' => 'mimes:pdf|max:7096', // unidade de medida kilobytes
            ];
        }
    }

    public function messages(): array
    {
        return [
            'name' => [
                'required' => 'O campo nome é obrigatorio',
                'max' => 'O campo nome aceita somente o máximo de :max caracteres',
            ],
            'video' => [
                'required' => 'O campo vídeo é obrigatório',
                'mimes' => 'O campo vídeo aceita somente as extensões MP4 e MOV',
                'max' => 'O tamanho máximo do vídeo é de 1GB',
            ],
            'pdf' => [
                'mimes' => 'O campo pdf aceita somente arquivos de tipo PDF',
                'max' => 'O campo pdf aceita o tamanho de 7MB'
            ],
            'module_id.required_if' => 'Relacionamento com a tabela módulo é inválido!'
        ];
    }
}
