<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use App\Models\User;

class RegisteredUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'min:8', 'max:255', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome precisa ser enviado',
            'name.string' => 'O campo nome precisa ser uma string',
            'name.max' => 'O campo nome precisa ter no máximo 255 caracteres',
            'email.required' => 'O campo email precisa ser enviado',
            'email.string' => 'O campo email precisa ser uma string',
            'email.lowercase' => 'O campo email precisa ser em minúsculo',
            'email.email' => 'O campo email precisa ser um email',
            'email.max' => 'O campo email precisa ter no máximo 255 caracteres',
            'email.unique' => 'O email informado já está em uso',
            'password.required' => 'O campo senha precisa ser enviado',
            'password.confirmed' => 'As senhas informadas não coincidem',
            'password.string' => 'O campo senha precisa ser uma string',
            'password.min' => 'O campo senha precisa ter no mínimo 8 caracteres',
            'password.max' => 'O campo senha precisa ter no máximo 255 caracteres',
            'password.regex' => 'O campo senha precisa ter pelo menos uma letra minúscula, uma letra maiúscula, um número e um caractere especial',
        ];
    }
}
