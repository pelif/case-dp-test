<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileDeleteRequest extends FormRequest
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
            'password' => ['required', 'current-password'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Por favor, insira sua senha atual.',
            'password.current-password' => 'A senha atual não corresponde à sua senha atual.',
        ];
    }
}
