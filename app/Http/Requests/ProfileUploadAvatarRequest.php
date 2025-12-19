<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUploadAvatarRequest extends FormRequest
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
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:10000'],
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.required' => 'O campo avatar precisa ser enviado',
            'avatar.image' => 'O campo avatar precisa ser uma imagem',
            'avatar.mimes' => 'O campo avatar precisa ser uma imagem com extensão jpeg, png, jpg ou gif',
            'avatar.max' => 'O campo avatar precisa ter no máximo 10000 KB'
        ];
    }
}
