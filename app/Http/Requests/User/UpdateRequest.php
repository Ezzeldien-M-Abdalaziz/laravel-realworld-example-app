<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user.username' => 'sometimes|string|max:50|unique:users,username',
            'user.email' => 'sometimes|email|max:255|unique:users,email',
            'user.password' => 'sometimes',
            'user.image' => 'sometimes|url',
            'user.bio' => 'sometimes|string|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'user.username.string' => 'The username field must be a string.',
            'user.username.max' => 'The username field must not be greater than 50 characters.',
            'user.email.email' => 'The email field must be a valid email address.',
            'user.email.max' => 'The email field must not be greater than 255 characters.',
            'user.password.string' => 'The password field must be a string.',
            'user.image.url' => 'The image field must be a valid URL.',
            'user.bio.string' => 'The bio field must be a string.',
            'user.bio.max' => 'The bio field must not be greater than 2048 characters.',
        ];
    }

}
