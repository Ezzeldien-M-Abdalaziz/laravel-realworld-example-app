<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'comment.body' => 'required|string|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'comment.body.required' => 'The body field is required.',
            'comment.body.string' => 'The body field must be a string.',
            'comment.body.max' => 'The body field must not be greater than 2048 characters.',
        ];
    }
}
