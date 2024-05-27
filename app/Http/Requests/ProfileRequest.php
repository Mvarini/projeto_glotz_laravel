<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::id(), //Ignora o e-mail do usuário logado
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'email' => [
                'required' => 'O campo e-mail é obrigatório',
                'email' => 'Necessário um e-mail valido',
                'unique' => 'O e-mail já está cadastrado',
            ],
        ];
    }
}
