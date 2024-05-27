<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'user_id' => 'required',
            'course_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo aluno é obrigatório',
            'course_id.required' => 'O campo curso é obrigatório',
        ];
    }
}
