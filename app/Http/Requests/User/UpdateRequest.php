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
            'user.username' => ['sometimes' ,'string' ,'max:50' , Rule::unique('users', 'username')->ignore($this->user()->id)],
            'user.email' => ['sometimes' , 'email' , 'max:255' , Rule::unique('users', 'email')->ignore($this->user()->id)],
            'user.password' => 'sometimes',
            'user.image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
