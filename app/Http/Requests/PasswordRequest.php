<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'current_password' => ['required', 'exists:users,password'],

            'password' => [
                'required',
                'min:8',
                'max:255',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'],

            'password_confirmation' => [
                'required',
                'min:8',
                'max:255',
                'same:password',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Por favor, insira sua senha atual.',
            'current_password.exists' => 'A senha atual informada é inválida',
            'password.required' => 'A nova senha é obrigatória.',
            'password.min' => 'A nova senha deve ter no mínimo 8 caracteres.',
            'password.max' => 'A nova senha deve ter no máximo 255 caracteres.',
            'password.regex' => 'A senha precisa ter pelo menos uma letra minúscula, uma letra maiúscula, um número e um caractere especial',
            'password_confirmation.required' => 'Por favor, confirme sua nova senha.',
            'password_confirmation.min' => 'A confirmação da nova senha deve ter no mínimo 8 caracteres.',
            'password_confirmation.max' => 'A confirmação da nova senha deve ter no máximo 255 caracteres.',
            'password_confirmation.same' => 'A confirmação da nova senha não coincide com a nova senha.',
            'password_confirmation.regex' => 'A senha precisa ter pelo menos uma letra minúscula, uma letra maiúscula, um número e um caractere especial',
        ];
    }
}
