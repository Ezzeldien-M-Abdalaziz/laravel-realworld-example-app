<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user.email' => 'required',
            'user.password' => 'required'
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();

        return [
            'email' => $data['user']['email'],
            'password' => $data['user']['password'],
        ];
    }

    public function messages()
    {
        return [
            'user.email.required' => 'The email field is required.',
            'user.password.required' => 'The password field is required.',
        ];
    }

}
