<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'username' => ['sometimes', 'string', 'max:50', Rule::unique('users', 'username')->ignore($this->user()->id)],
        'email' => ['sometimes', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user()->id)],
        'password' => 'sometimes',
        'image' => ['nullable' , 'image' , 'mimes:jpeg,png,jpg,gif,svg' , 'max:2048'],
        'bio' => 'sometimes|string|max:2048'
    ];
}

public function messages()
{
    return [
        'username.string' => 'The username field must be a string.',
        'username.max' => 'The username field must not be greater than 50 characters.',
        'email.email' => 'The email field must be a valid email address.',
        'email.max' => 'The email field must not be greater than 255 characters.',
        'password.string' => 'The password field must be a string.',
        'image' => 'The image field must be an image.',
        'bio.string' => 'The bio field must be a string.',
        'bio.max' => 'The bio field must not be greater than 2048 characters.',
    ];
}

}
